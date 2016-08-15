<?php

namespace backend\modules\artGallery\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\artGallery\models\Artist;

/**
 * ArtistSearch represents the model behind the search form about `backend\modules\artGallery\models\Artist`.
 */
class ArtistSearch extends Artist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prefix_id', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name', 'surname', 'sex', 'phone', 'email', 'other','fullname'], 'safe'],
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

     public $fullname;
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    
    public function search($params)
    {
        $query = Artist::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
        'attributes' => [
            'id' => [
                'asc' => ['id' => SORT_ASC],
                'desc' => ['id' => SORT_DESC],                
                'default' => SORT_ASC
            ],
            'fullname' => [
                'asc' => ['name' => SORT_ASC, 'surname' => SORT_ASC],
                'desc' => ['name' => SORT_DESC, 'surname' => SORT_DESC],
                'label' => 'Full Name',
                'default' => SORT_ASC
            ],
    ]]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'prefix_id' => $this->prefix_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'other', $this->other]);
        $query->andWhere('name LIKE "%' . $this->fullname . '%" ' .'OR surname LIKE "%' . $this->fullname . '%"');

        return $dataProvider;
    }
}
