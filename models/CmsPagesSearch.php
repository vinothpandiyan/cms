<?php

namespace caritor\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use caritor\cms\models\CmsPages;
use common\models\User;


/**
 * CmsPagesSearch represents the model behind the search form about `caritor\cms\models\CmsPages`.
 */
class CmsPagesSearch extends CmsPages
{
    
    public $created_by;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by'], 'safe'],
            [['page_id'], 'integer'],
            [['title', 'description', 'status', 'menu_title', 'created_at', 'updated_at'], 'safe'],
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
        $query = CmsPages::find();

        // add conditions that should always apply here
        $query->joinWith(['user']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,            
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'page_id' => $this->page_id,
            //'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'username', $this->created_by])
            ->andFilterWhere(['like', 'cms_pages.status', $this->status])
            ->andFilterWhere(['like', 'menu_title', $this->menu_title]);

        return $dataProvider;
    }
}
