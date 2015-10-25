<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property integer $id
 * @property integer $id_categoria
 * @property string $nombre
 * @property string $imagen
 * @property string $descripcion
 *
 * @property Categorias $idCategoria
 * @property ProductosComercioStock[] $productosComercioStocks
 * @property Comercios[] $idComercios
 * @property ProductosPedidos[] $productosPedidos
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_categoria', 'nombre'], 'required'],
            [['id_categoria'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['imagen'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_categoria' => 'Id Categoria',
            'nombre' => 'Nombre',
            'imagen' => 'Imagen',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosComercioStocks()
    {
        return $this->hasMany(ProductosComercioStock::className(), ['id_producto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComercios()
    {
        return $this->hasMany(Comercios::className(), ['id' => 'id_comercio'])->viaTable('productosComercioStock', ['id_producto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosPedidos()
    {
        return $this->hasMany(ProductosPedidos::className(), ['id_producto' => 'id']);
    }
}
