<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productosComercioStock".
 *
 * @property integer $id_comercio
 * @property integer $id_producto
 * @property string $cantidad
 *
 * @property Productos $idProducto
 * @property Comercios $idComercio
 */
class ProductoComercioStock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productosComercioStock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_comercio', 'id_producto'], 'required'],
            [['id_comercio', 'id_producto'], 'integer'],
            [['cantidad'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_comercio' => Yii::t('app', 'Id Comercio'),
            'id_producto' => Yii::t('app', 'Id Producto'),
            'cantidad' => Yii::t('app', 'Cantidad'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComercio()
    {
        return $this->hasOne(Comercios::className(), ['id' => 'id_comercio']);
    }
}
