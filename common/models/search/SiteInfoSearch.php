<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SiteInfo;

/**
 * SiteInfoSearch represents the model behind the search form of `common\models\SiteInfo`.
 */
class SiteInfoSearch extends SiteInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['phone_number', 'email', 'address', 'secondary_address', 'start_week', 'end_week', 'start_time', 'end_time', 'facebook_url', 'instagram_url', 'telegram_url', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = SiteInfo::find();

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
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'phone_number', $this->phone_number])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'secondary_address', $this->secondary_address])
            ->andFilterWhere(['ilike', 'start_week', $this->start_week])
            ->andFilterWhere(['ilike', 'end_week', $this->end_week])
            ->andFilterWhere(['ilike', 'start_time', $this->start_time])
            ->andFilterWhere(['ilike', 'end_time', $this->end_time])
            ->andFilterWhere(['ilike', 'facebook_url', $this->facebook_url])
            ->andFilterWhere(['ilike', 'instagram_url', $this->instagram_url])
            ->andFilterWhere(['ilike', 'telegram_url', $this->telegram_url]);

        return $dataProvider;
    }
}
