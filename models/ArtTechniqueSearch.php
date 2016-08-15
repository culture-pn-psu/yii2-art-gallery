<?php

namespace backend\modules\artGallery\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\artGallery\models\ArtTechnique;

/**
 * ArtTechniqueSearch represents the model behind the search form about `backend\modules\artGallery\models\ArtTechnique`.
 */
class ArtTechniqueSearch extends ArtTechnique
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['art_type_id', 'id'], 'integer'],
            [['title'], 'safe'],
        ];
    }

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
        $query = ArtTechnique::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'art_type_id' => $this->art_type_id,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
