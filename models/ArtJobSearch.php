<?php

namespace culturePnPsu\artGallery\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use culturePnPsu\artGallery\models\ArtJob;

/**
 * ArtJobSearch represents the model behind the search form about `culturePnPsu\artGallery\models\ArtJob`.
 */
class ArtJobSearch extends ArtJob
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title', 'size', 'unit', 'concept', 'note','art_code','year'], 'safe'],
            [['status', 'art_type_id', 'art_technique_id', 'artist_id', 'created_by', 'created_at', 'updated_by', 'updated_at','own'], 'integer'],
        ];
    }
    public $own;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArtJob::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //$query->joinWith('artist');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
            //'art_code' => $this->art_code,
            'art_type_id' => $this->art_type_id,
            'art_technique_id' => $this->art_technique_id,
            'artist_id' => $this->artist_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'art_code', $this->art_code])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'concept', $this->concept])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'image_id', $this->image_id]);
                

        return $dataProvider;
    }
}
