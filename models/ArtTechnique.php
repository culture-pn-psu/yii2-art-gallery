<?php

namespace culturePnPsu\artGallery\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "art_technique".
 *
 * @property integer $art_type_id
 * @property integer $id
 * @property string $title
 *
 * @property ArtJob[] $artJobs
 * @property ArtType $artType
 */
class ArtTechnique extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'art_technique';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['art_type_id', 'id'], 'required'],
            [['art_type_id', 'id'], 'integer'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'art_type_id' => Yii::t('art', 'ประเภท'),
            'id' => Yii::t('art', 'ID'),
            'title' => Yii::t('art', 'เทคนิค'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtJobs()
    {
        return $this->hasMany(ArtJob::className(), ['art_technique_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtType()
    {
        return $this->hasOne(ArtType::className(), ['id' => 'art_type_id']);
    }
    
     public static function getList()
    {
        return ArrayHelper::map(self::find()->all(),'id','title');
    }
}
