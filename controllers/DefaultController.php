<?php

namespace culturePnPsu\artGallery\controllers;

use Yii;
use culturePnPsu\artGallery\models\ArtJob;
use culturePnPsu\artGallery\models\ArtJobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for ArtJob model.
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ArtJob models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ArtJobSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArtJob model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ArtJob model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null) {

        if ($id == null) {
            $model = new ArtJob(['scenario' => 'start']);
            $model->status = 0;
            if ($model->save(false)) {
                return $this->redirect(['create', 'id' => $model->id]);
            }
        } else {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                $post = Yii::$app->request->post('ArtJob');
                $model->art_code = ArtJob::genId($post['art_type_id'], $post['art_technique_id'], $post['year']);
                //$model->old_id = $model->id;
                if ($model->save()) {
                    return $this->redirect(['update', 'id' => $model->id]);
                } else {
                    print_r($model->getErrors());
                }
            }

            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ArtJob model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $artTechnique = ArrayHelper::map($this->getTechnique($model->art_type_id), 'id', 'name');

        if ($model->load(Yii::$app->request->post())) {
            //print_r(Yii::$app->request->post());
            //exit();
            $post = Yii::$app->request->post('ArtJob');
            $model->art_code = ArtJob::genId($post['art_type_id'], $post['art_technique_id'], $post['year'], $model->art_code);
            // $model->old_id = $model->id;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                print_r($model->getErrors());
                exit();
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'artTechnique' => $artTechnique
        ]);
    }

    /**
     * Deletes an existing ArtJob model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ArtJob model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ArtJob the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ArtJob::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    ##############################################

    public function actionUploadajax() {
        $this->uploadMultipleFile();
    }

    private function uploadMultipleFile() {
        $files = [];
        $json = '';
        if (Yii::$app->request->isPost) {
            $img = Yii::$app->img;
            $UploadedFiles = \yii\web\UploadedFile::getInstancesByName('ArtJob[images_file]');
            $upload_folder = Yii::$app->request->post('upload_folder');
            $id = Yii::$app->request->post('id');
            $model = $this->findModel($id);
            $tempFile = Json::decode($model->images);

            $pathFile = $img->getUploadPath() . $upload_folder;
//            print_r($tempFile);
//            exit();
            if ($UploadedFiles !== null) {
                $img->CreateDir($upload_folder);
                foreach ($UploadedFiles as $key => $file) {
                    try {
                        $oldFileName = $file->basename . '.' . $file->extension;
                        $newFileName = $file->basename . '.' . $file->extension;
                        $newFileNameLarge = $file->basename . '.' . $file->extension;

                        $file->saveAs($pathFile . '/' . $newFileName);
                        $files[$newFileName] = $newFileName;
                        $image = Yii::$app->image->load($pathFile . '/' . $newFileName);
                        $image->resize(1000);
                        $image->save($pathFile . '/' . $newFileName);

                        $image = Yii::$app->image->load($pathFile . '/' . $newFileName);
                        $image->resize(200);
                        $image->save($pathFile . '/thumbnail/' . $newFileNameLarge);
                    } catch (Exception $e) {
                        
                    }
                }

                //print_r($json);
                $model = $this->findModel($id);
                $model->images = ArtJob::findFiles($pathFile);
                if ($model->save(false)) {
                    echo json_encode(['success' => 'true', 'file' => $files, 'temp' => $tempFile, 'json' => $json]);
                } else {
                    echo json_encode(['success' => 'false', 'error' => $model->getErrors()]);
                }
            } else {
                echo json_encode(['success' => 'false',]);
            }
        }
    }

    public function initialPreview($data, $field, $type = 'file') {
        $initial = [];
        $files = Json::decode($data);
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                if ($type == 'file') {
                    $initial[] = "<div class='file-preview-other'><h2><i class='glyphicon glyphicon-file'></i></h2></div>";
                } elseif ($type == 'config') {
                    $initial[] = [
                        'caption' => $value,
                        'width' => '120px',
                        'url' => Url::to(['/freelance/deletefile', 'id' => $this->id, 'fileName' => $key, 'field' => $field]),
                        'key' => $key
                    ];
                } else {
                    $initial[] = Html::img(self::getUploadUrl() . $this->ref . '/' . $value, ['class' => 'file-preview-image', 'alt' => $model->file_name, 'title' => $model->file_name]);
                }
            }
        }
        return $initial;
    }

    public function actionDeletefileAjax($id, $folder = null, $fileName = null) {
        $file = Yii::$app->img->getUploadPath($folder . '/' . $id) . $fileName;
        $pathFile = Yii::$app->img->getUploadPath($folder . '/' . $id);
        $model = ArtJob::findOne($id);
//        $data = Json::decode($model->images);
//        unset($data[$fileName]);

        if (@unlink($file)) {
            $model->images = ArtJob::findFiles($pathFile);
            if ($model->save(false)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => $model->getErrors()]);
        }
    }

    public function actionPdf($id = null, $download = NULL) {
        // get your HTML raw content without any layouts or scripts
        if ($id) {
            $id_new = (strpos($id, ',')) ? explode(',', $id) : [$id];
            $all = ArtJob::find()->where(['IN', 'id', $id_new])->all();
            $content = '';
            foreach ($all as $model) {
                file_get_contents(Yii::$app->urlManagerFrontend->createUrl(['/south-gallery/default/qrcode', 'id' => $model->id]));
                //file_get_contents(\yii\helpers\Url::to(['qrcode','art_code'=>$model->art_code],true));
                $content .= $this->renderPartial('pdf', [
                    'model' => $model,
                ]);
            }
        } else {
            $all = ArtJob::find()->all();
            $content = '';
            foreach ($all as $model) {
                file_get_contents(Yii::$app->urlManagerFrontend->createUrl(['/south-gallery/default/qrcode', 'id' => $model->id]));
                //file_get_contents(\yii\helpers\Url::to(['qrcode','art_code'=>$model->art_code],true));
                $content .= $this->renderPartial('pdf', [
                    'model' => $model,
                ]);
            }
        }


        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            //'format' => [148, 210],
            // portrait orientation
            'filename' => Yii::$app->img->getUploadPath('export/pdf') . 'art.pdf',
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => [
                'title' => 'รายงาน',
                'subject' => 'รายงาน1',
                'keywords' => 'รายงาน2',
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false,
                'SetFooter' => false,
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionQrcode($art_code = null) {
//        header("Content-Type: image/png");
//        $art_code = $art_code ? $art_code : \yii\helpers\Url::to(['index'], true);
        $data = \dosamigos\qrcode\QrCode::png($art_code, Yii::$app->img->getUploadPath('qrcode') . $art_code . '.png');
        return $data;
    }

    public function actionQrdown($art_code = null) {

        $file_name = 'qrcode.png';
        $mime = 'application/force-download';
        //header('Pragma: public'); // required
        //header('Expires: 0'); // no cache
        //header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header("Content-Type: image/png");
        echo $this->actionQrcode($art_code);
        //header('Content-Type: ' . $mime);
        //header('Content-Description: File Transfer');
        // header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
        //header('Content-Transfer-Encoding: binary');
        //header('Connection: close');
        //readfile($image); // push it out
        exit();
    }

    public function actionGetTechnique() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $art_type_id = $parents[0];
                $out = $this->getTechnique($art_type_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getTechnique($id) {
        $datas = \culturePnPsu\artGallery\models\ArtTechnique::find()->where(['art_type_id' => $id])->all();
        return $this->MapData($datas, 'id', 'title');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

}
