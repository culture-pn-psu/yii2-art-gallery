<?php

namespace culturePnPsu\artGallery\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\image\models\Image;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "art_job".
 *
 * @property string $id
 * @property string $title
 * @property integer $status
 * @property string $size
 * @property string $unit
 * @property integer $art_type_id
 * @property integer $art_technique_id
 * @property integer $artist_id
 * @property string $concept
 * @property string $note
 * @property string $image_id
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 *
 * @property ArtType $artType
 * @property ArtTechnique $artTechnique
 * @property Artist $artist
 * @property User $createdBy
 * @property User $updatedBy
 * @property ArtistJobJoin[] $artistJobJoins
 * @property Artist[] $artists
 */
class ArtJob extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'art_job';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['art_code', 'title', 'art_type_id', 'art_technique_id', 'artist_id', 'year'], 'required'],
            //[['id'], 'required','on'=>'update'],
            [['status', 'art_type_id', 'art_technique_id', 'artist_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['concept', 'note', 'images'], 'string'],
            //[['id'], 'string', 'max' => 14],
            [['title'], 'string', 'max' => 100],
            [['size'], 'string', 'max' => 10],
            [['unit'], 'string', 'max' => 10],
            [['image_id'], 'string']
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['start'] = ['id', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('art', 'Id'),
            'art_code' => Yii::t('art', 'รหัสผลงาน'),
            'title' => Yii::t('art', 'ชื่อผลงาน'),
            'status' => Yii::t('art', 'สถานะ'),
            'size' => Yii::t('art', 'ขนาด'),
            'unit' => Yii::t('art', 'หน่วย'),
            'art_type_id' => Yii::t('art', 'ประเภท'),
            'art_technique_id' => Yii::t('art', 'เทคนิค'),
            'year' => Yii::t('art', 'ปี'),
            'artist_id' => Yii::t('art', 'ศิลปิน'),
            'concept' => Yii::t('art', 'แนวความคิด'),
            'note' => Yii::t('art', 'หมายเหตุ'),
            'image_id' => Yii::t('art', 'หน้าปก'),
            'images' => Yii::t('art', 'รูปภาพ'),
            'images_file' => Yii::t('art', 'ภาพผลงาน'),
            'created_by' => Yii::t('art', 'สร้างโดย'),
            'created_at' => Yii::t('art', 'สร้างเมื่อ'),
            'updated_by' => Yii::t('art', 'แก้ไขโดย'),
            'updated_at' => Yii::t('art', 'แก้ไขเมื่อ'),
            'own' => Yii::t('art', 'ศิลปิน'),
        ];
    }

    public function attributeHints() {
        return [
            'year' => Yii::t('art', 'ตัวอย่าง 2559'),
        ];
    }

    ####################################
    ####################################

    const UPLOAD_FOLDER = 'artJob';
    const width = 1024;

    //const height = 158;

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('app', 'ร่าง'),
                1 => Yii::t('app', 'เผยแพร่'),
                2 => Yii::t('app', 'ปรับปรุง'),
            ],
            'unit' => [
                1 => 'เซนติเมตร',
                2 => 'นิ้ว',
            ],
            'unitShort' => [
                1 => 'ซ.ม.',
                2 => 'นิ้ว',
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case '0' :
            case NULL :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case '1' :
                $str = '<span class="label label-primary">' . $status . '</span>';
                break;
            case '2' :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    public function getUnitLabel() {
        return ArrayHelper::getValue($this->getItemUnit(), $this->unit);
    }

    public function getUnitLabelShort() {
        return ArrayHelper::getValue($this->getItemUnitShort(), $this->unit);
    }

    public static function getItemUnit() {
        return self::itemsAlias('unit');
    }

    public static function getItemUnitShort() {
        return self::itemsAlias('unitShort');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtType() {
        return $this->hasOne(ArtType::className(), ['id' => 'art_type_id']);
    }
    public function getArtTypeTitle() {
        return $this->art_type_id?$this->artType->title:null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtTechnique() {
        return $this->hasOne(ArtTechnique::className(), ['id' => 'art_technique_id']);
    }
    public function getArtTechniqueTitle() {
        return $this->art_technique_id?$this->artTechnique->title:null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtist() {
        return $this->hasOne(Artist::className(), ['id' => 'artist_id']);
    }

    //public $own;
    public function getOwn() {
        return $this->artist_id ? $this->artist->fullname : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getImage() {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtistJobJoins() {
        return $this->hasMany(ArtistJobJoin::className(), ['art_job_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtists() {
        return $this->hasMany(Artist::className(), ['id' => 'artist_id'])->viaTable('artist_job_join', ['job_id' => 'id']);
    }

    ##########################################
    ##########################################

    public function getSizeUnit() {
        return $this->size . ' ' . $this->unitLabel;
    }

    public function getSizeUnitShort() {
        return $this->size . ' ' . $this->unitLabelShort;
    }

    public function getImgTemp() {
        return (isset($this->image_id) ? Yii::$app->img->getUploadThumbnailUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $this->image_id : Yii::$app->img->no_img);
    }

    public static function genId($type_id, $technique_id, $year, $old_id = null) {
        $new_id = [];
        $model = self::find()->where(['art_type_id' => $type_id, 'art_technique_id' => $technique_id, 'year' => $year])->one();

        if (!empty($model)) {//กรณีที่มีข้อมูล
            if ($old_id == null) {//กรณีที่มีข้อมูลซ่ำกันให้+1            
                list($type, $technique, $id, $y) = explode('-', $model->art_code);
                return self::createId($type_id, $technique_id, (intval($id) + 1), $year);
            } else {//ข้อมูลใหม่
                list($type, $technique, $id, $y) = explode('-', $old_id);
                $id = self::createId($type_id, $technique_id, $id, $year);
                if ($old_id != $id) {//เปลี่ยนประเภท
                    $model = self::find()->where(['art_code' => $id])->one();
                    if (!empty($model)) {//กรณีที่มีข้อมูล
                        list($type, $technique, $id, $y) = explode('-', $model->art_code);
                        return self::createId($type_id, $technique_id, (intval($id) + 1), $year);
                    } else {
                        return $id;
                    }
                } else {
                    return $old_id;
                }
            }
        } else {
            $id = 1;
            return self::createId($type_id, $technique_id, $id, $year);
        }
    }

    public static function createId($type_id, $technique_id, $id, $year) {
        $new_id = [];
        $new_id[] = str_pad((int) $type_id, 2, "0", STR_PAD_LEFT);
        $new_id[] = str_pad((int) $technique_id, 2, "0", STR_PAD_LEFT);
        $new_id[] = str_pad((int) $id, 4, "0", STR_PAD_LEFT);
        $new_id[] = substr((int) $year, 2, 2);
        return implode('-', $new_id);
    }

    public function getDisplaynameImg() {
        return $this->artist_id ? Html::beginTag('div', ['class' => 'user-circle'])
                . Html::beginTag('div', ['class' => 'circle', 'style' => ''])
                . Html::img($this->artist->ImgTemp, ['class' => '', 'style' => '', 'width' => '100%'])
                . Html::endTag('div')
                . Html::beginTag('span', ['class' => 'username', 'style' => ''])
                . Html::a($this->artist->fullname, ['/art-gallery/artist/view', 'id' => $this->id])
//                . Html::beginTag('span', ['class' => 'description'])
//                . $this->personPosition . ' ' . $this->personParent
//                . (($this->person) ? ($this->person->tel ? '<br />เบอร์ติดต่อ ' . $this->person->tel : '') : '')
//                . Html::endTag('span')
                . Html::endTag('span')
                . Html::endTag('div') : null;
    }

    public static function getSizeAll() {
        $model = self::find()->where(['!=','size',''])->distinct('size')->orderBy('size DESC')->all();
        return ArrayHelper::map($model, 'size', 'size');
    }

    public static function getYearAll() {
        $model = self::find()->distinct('year')->all();
        return ArrayHelper::map($model, 'year', 'year');
    }

    public $images_file;

    public function initialPreview($data, $field, $type = 'file') {
        $initial = [];
        $files = '';
        if (!empty($data)) {
//            print_r($data);
//            exit();
            $files = \yii\helpers\Json::decode($data);
            ksort($files);
        }
        //$files = '';
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                if ($type == 'file') {
                    $initial[] = \yii\helpers\Html::img(Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $value, ['class' => 'file-preview-image', 'style' => 'width:100px;height:auto;']);
                } elseif ($type == 'config') {
                    $initial[] = [
                        'caption' => $value,
                        //'width' => '100px',
                        'url' => \yii\helpers\Url::to(['deletefile-ajax', 'id' => $this->id, 'fileName' => $value, 'field' => $field, 'folder' => self::UPLOAD_FOLDER]),
                        'key' => $value
                    ];
                } else {
                    $initial[] = Html::img(self::getUploadUrl() . $this->ref . '/' . $value, ['class' => 'file-preview-image', 'alt' => $model->file_name, 'title' => $model->file_name]);
                }
            }
        }
        return $initial;
    }

    public static function findFiles($pathFile) {
        $files = [];
        $findFiles = \yii\helpers\FileHelper::findFiles($pathFile);
        ksort($findFiles);
        // set pdfs as target folder
        //print_r($findFiles);
        foreach ($findFiles as $index => $file) {
            if (strpos($file, 'thumbnail') === false) {
                $nameFicheiro = substr($file, strrpos($file, '/') + 1);
                $files[$nameFicheiro] = $nameFicheiro;
            }
        }
        return $files ? \yii\helpers\Json::encode($files) : null;
    }

    public function getThumbnails() {
        $imeges = \yii\helpers\Json::decode($this->images);
        $img = [];
        if ($imeges) {
            ksort($imeges);

            $url = Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id);
            $urlThumbnails = Yii::$app->img->getUploadThumbnailUrl(self::UPLOAD_FOLDER . '/' . $this->id);
            if (is_array($imeges)) {
                foreach ($imeges as $key => $value) {
                    $img[] = [
                        'url' => $url . $value,
                        'src' => $urlThumbnails . $value,
                        'options' => [
                            'title' => $this->title,
                            'class' => 'col-xs-12 col-sm-4 art-img thumbnail'
                    ]];
                }
            }
        }
        return $img;
    }

    public function getCarousel() {
        $imeges = \yii\helpers\Json::decode($this->images);
        $img = [];
        if ($imeges) {
            ksort($imeges);

            $url = Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER . '/' . $this->id);
            $urlThumbnails = Yii::$app->img->getUploadThumbnailUrl(self::UPLOAD_FOLDER . '/' . $this->id);
            if (is_array($imeges)) {
                foreach ($imeges as $key => $value) {
                    $img[] = [ 'content' => Html::img($url . $value, ['width' => '100%']), 'options' => ['width' => '100%']];
                }
            }
        }
        return $img;
    }

    public static function genYear() {
        $start = date('Y') + 543;
        $end = 2549;

        $range = range($start, $end);
        return array_combine($range, $range);
    }

    public function getQrcode() {
        return Yii::$app->img->getUploadUrl('qrcode') . $this->art_code . '.png';
    }

    public static function getForIndex() {
        $query = self::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC,
                ]
            ],
        ]);

        return $provider;
    }

}
