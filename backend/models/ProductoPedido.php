<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "productosPedidos".
 *
 * @property integer $id_pedido
 * @property integer $id_producto
 * @property string $cantidad
 *
 * @property Pedidos $idPedido
 * @property Productos $idProducto
 */
class ProductoPedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productosPedidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pedido', 'id_producto'], 'required'],
            [['id_pedido', 'id_producto'], 'integer'],
            [['cantidad'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pedido' => Yii::t('app', 'Id Pedido'),
            'id_producto' => Yii::t('app', 'Id Producto'),
            'cantidad' => Yii::t('app', 'Cantidad'),
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
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'id_producto']);
    }
}
