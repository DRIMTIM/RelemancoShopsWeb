<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Ruta;

/**
 * BuscarRutas represents the model behind the search form about `backend\models\Ruta`.
 */
class BuscarRutas extends Ruta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_estado'], 'integer'],
            [['fecha_asignada'], 'safe'],
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
        $query = Ruta::find();

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
            'id' => $this->id,
            'fecha_asignada' => $this->fecha_asignada,
            'id_estado' => $this->id_estado,
        ]);

        return $dataProvider;
    }
}
