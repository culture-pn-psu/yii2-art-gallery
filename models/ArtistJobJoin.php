<?php

namespace culturePnPsu\artGallery\models;

use Yii;

/**
 * This is the model class for table "artist_job_join".
 *
 * @property integer $artist_id
 * @property string $job_id
 *
 * @property Artist $artist
 * @property ArtJob $job
 */
class ArtistJobJoin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'artist_job_join';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['artist_id', 'job_id'], 'required'],
            [['artist_id'], 'integer'],
            [['job_id'], 'string', 'max' => 14]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'artist_id' => Yii::t('art', 'รหัสศิลปิน'),
            'job_id' => Yii::t('art', 'รหัสผลงาน'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtist()
    {
        return $this->hasOne(Artist::className(), ['id' => 'artist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(ArtJob::className(), ['id' => 'job_id']);
    }
}
