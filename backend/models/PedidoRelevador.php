<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pedidosRelevadores".
 *
 * @property integer $id_pedido
 * @property integer $id_relevador
 *
 * @property Pedidos $idPedido
 * @property Relevadores $idRelevador
 */
class PedidoRelevador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedidosRelevadores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pedido', 'id_relevador'], 'required'],
            [['id_pedido', 'id_relevador'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pedido' => Yii::t('app', 'Id Pedido'),
            'id_relevador' => Yii::t('app', 'Id Relevador'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPedido()
    {
        return $this->hasOne(Pedidos::className(), ['id' => 'id_pedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRelevador()
    {
        return $this->hasOne(Relevadores::className(), ['id' => 'id_relevador']);
    }
}
