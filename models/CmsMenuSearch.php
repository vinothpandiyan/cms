<?php

namespace caritor\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use caritor\cms\models\CmsMenu;

/**
 * CmsMenuSearch represents the model behind the search form about `caritor\cms\models\CmsMenu`.
 */
class CmsMenuSearch extends CmsMenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'page_id', 'parent_menu_id', 'area_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = CmsMenu::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'menu_id' => $this->menu_id,
            'page_id' => $this->page_id,
            'parent_menu_id' => $this->parent_menu_id,
            'area_id' => $this->area_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
