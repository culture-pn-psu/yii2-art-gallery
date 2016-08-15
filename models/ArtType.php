<?php

namespace backend\modules\artGallery\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "art_type".
 *
 * @property integer $id
 * @property string $title
 *
 * @property ArtJob[] $artJobs
 * @property ArtTechnique[] $artTechniques
 */
class ArtType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'art_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('art', 'รหัสประเภท'),
            'title' => Yii::t('art', 'ประเภท'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtJobs()
    {
        return $this->hasMany(ArtJob::className(), ['artist_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtTechniques()
    {
        return $this->hasMany(ArtTechnique::className(), ['artist_type_id' => 'id']);
    }
    
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(),'id','title');
    }
}
