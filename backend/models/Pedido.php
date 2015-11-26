<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pedidos".
 *
 * @property integer $id
 * @property integer $id_comercio
 * @property string $fecha_realizado
 *
 * @property Comercios $idComercio
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
            [['id_comercio'], 'required'],
            [['id_comercio'], 'integer'],
            [['fecha_realizado'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_comercio' => Yii::t('app', 'Id Comercio'),
            'fecha_realizado' => Yii::t('app', 'Fecha Realizado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComercio()
    {
        return $this->hasOne(Comercios::className(), ['id' => 'id_comercio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosPedidos()
    {
        return $this->hasMany(ProductosPedidos::className(), ['id_pedido' => 'id']);
    }
}
