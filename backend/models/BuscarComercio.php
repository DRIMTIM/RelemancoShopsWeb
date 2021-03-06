<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Comercio;

/**
 * BuscarComercio represents the model behind the search form about `app\models\Comercio`.
 */
class BuscarComercio extends Comercio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_localizacion', 'id_prioridad'], 'integer'],
            [['nombre'], 'safe'],
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
        $query = Comercio::find()->with('prioridad');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['prioridad.nombre'] = [
            'asc' => ['id_prioridad' => SORT_ASC],
            'desc' => ['id_prioridad' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_localizacion' => $this->id_localizacion,
            'id_prioridad' => $this->id_prioridad,
        ]);

        $query->andFilterWhere(['like', 'id_prioridad', $this->id_prioridad]);
        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchQuery($query, $params = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['prioridad.nombre'] = [
            'asc' => ['id_prioridad' => SORT_ASC],
            'desc' => ['id_prioridad' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_localizacion' => $this->id_localizacion,
            'id_prioridad' => $this->id_prioridad,
        ]);

        $query->andFilterWhere(['like', 'id_prioridad', $this->id_prioridad]);
        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
