<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedidos".
 *
 * @property integer $id
 * @property string $fecha_realizado
 *
 * @property PedidosComercios[] $pedidosComercios
 * @property ProductosPedidos[] $productosPedidos
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_realizado'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_realizado' => 'Fecha Realizado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidosComercios()
    {
        return $this->hasMany(PedidosComercios::className(), ['id_pedido' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosPedidos()
    {
        return $this->hasMany(ProductosPedidos::className(), ['id_pedido' => 'id']);
    }
}
