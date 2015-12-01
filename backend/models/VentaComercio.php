<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ventasComercios".
 *
 * @property integer $id
 * @property integer $id_comercio
 * @property integer $id_producto
 * @property string $fecha_realizado
 * @property string $cantidad
 *
 * @property Comercios $idComercio
 * @property Productos $idProducto
 */
class VentaComercio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ventasComercios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_comercio', 'id_producto'], 'required'],
            [['id_comercio', 'id_producto'], 'integer'],
            [['fecha_realizado'], 'safe'],
            [['cantidad'], 'number']
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
            'id_producto' => Yii::t('app', 'Id Producto'),
            'fecha_realizado' => Yii::t('app', 'Fecha Realizado'),
            'cantidad' => Yii::t('app', 'Cantidad'),
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
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'id_producto']);
    }
}
