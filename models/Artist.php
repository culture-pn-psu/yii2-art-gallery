<?php

namespace backend\modules\artGallery\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\image\models\Image;
use backend\modules\person\models\Prefix;
use common\models\User;
use yii\helpers\Html;

/**
 * This is the model class for table "artist".
 *
 * @property integer $id
 * @property integer $prefix_id
 * @property string $name
 * @property string $surname
 * @property string $sex
 * @property string $phone
 * @property string $email
 * @property string $other
 * @property integer $status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 *
 * @property ArtJob[] $artJobs
 * @property User $createdBy
 * @property User $updatedBy
 * @property ArtistJobJoin[] $artistJobJoins
 * @property ArtJob[] $jobs
 */
class Artist extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'artist';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['prefix_id', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name', 'surname'], 'required'],
            [['sex', 'other'], 'string'],
            [['name', 'surname'], 'string', 'max' => 100],
            [['phone', 'email', 'image_id'], 'string', 'max' => 50],
            //[[ 'image_id'], 'on','update'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('art', 'รหัสศิลปิน'),
            'prefix_id' => Yii::t('art', 'คำนำหน้า'),
            'name' => Yii::t('art', 'ชื่อ'),
            'surname' => Yii::t('art', 'นามสกุล'),
            'sex' => Yii::t('art', 'เพศ'),
            'phone' => Yii::t('art', 'โทรศัพท์'),
            'email' => Yii::t('art', 'อีเมลล์'),
            'other' => Yii::t('art', 'ข้อมูลอื่นๆ'),
            'status' => Yii::t('art', 'สถานะ'),
            'created_by' => Yii::t('art', 'สร้างโดย'),
            'created_at' => Yii::t('art', 'สร้างเมื่อ'),
            'updated_by' => Yii::t('art', 'ปรับปรุงโดย'),
            'updated_at' => Yii::t('art', 'ปรับปรุงเมื่อ'),
            'image_id' => Yii::t('art', 'รูปประจำตัว'),
            'fullname' => Yii::t('art', 'ชื่อ - สกุล'),
        ];
    }

    const UPLOAD_FOLDER = 'artist';
    const width = 300;
    //public $fullname;
    
    public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('app', 'ร่าง'),
                1 => Yii::t('app', 'เสนอ'),
                2 => Yii::t('app', 'อนุมัติ'),
                3 => Yii::t('app', 'ไม่อนุมัติ'),
                4 => Yii::t('app', 'ยกเลิก'),
            ],
            'sex' => [
                'm' => 'ชาย',
                'f' => 'หญิง',
            ]
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        return ArrayHelper::getValue($this->getItemStatus(), $this->status);
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }
    
    public function getSexLabel() {
        return ArrayHelper::getValue($this->getItemSex(), $this->sex);
    }

    public static function getItemSex() {
        return self::itemsAlias('sex');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtJobs() {
        return $this->hasMany(ArtJob::className(), ['artist_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtistJobJoins() {
        return $this->hasMany(ArtistJobJoin::className(), ['artist_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobs() {
        return $this->hasMany(ArtJob::className(), ['id' => 'art_job_id'])->viaTable('artist_job_join', ['artist_id' => 'id']);
    }

    public function getPrefix() {
        return $this->hasOne(Prefix::className(), ['id' => 'prefix_id']);
    }

    public function getFullname() {
        return ($this->prefix_id ? $this->prefix->title . ' ' : null) . $this->name . ' ' . $this->surname;
    }
    
    public function getFullnameArtist() {
        return 'Artist '. $this->name . ' ' . $this->surname;
    }

    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'fullnameArtist');
    }

    public function getImage() {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    public function getImgTemp() {
        $model = $this->image;
        return (isset($model->id) ? Yii::$app->img->getUploadUrl(self::UPLOAD_FOLDER) . $model->id : Yii::$app->img->getUploadUrl() . Yii::$app->img->no_img);
    }

    public function getDisplaynameImg() {
        return $this->id?Html::beginTag('div', ['class' => 'user-circle'])
                . Html::beginTag('div', ['class' => 'circle', 'style' => ''])
                . Html::img($this->ImgTemp, ['class' => '', 'style' => '','width'=>'100%','height'=>'auto'])
                . Html::endTag('div')
                . Html::beginTag('span', ['class' => 'username', 'style' => ''])
                . Html::a($this->fullname, ['/art-gallery/artist/view','id'=>$this->id])
//                . Html::beginTag('span', ['class' => 'description'])
//                . $this->personPosition . ' ' . $this->personParent
//                . (($this->person) ? ($this->person->tel ? '<br />เบอร์ติดต่อ ' . $this->person->tel : '') : '')
//                . Html::endTag('span')
                . Html::endTag('span')
                . Html::endTag('div'):null;
    }
}
