<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use app\models\UploadForm;

/**
 * This is the model class for table "productos".
 *
 * @property integer $id
 * @property integer $id_categoria
 * @property string $nombre
 * @property string $imagen
 * @property string $descripcion
 *
 * @property Categoria $categoria
 * @property ProductosComercioStock[] $productosComercioStock
 * @property Comercios[] $idComercios
 * @property ProductosPedidos[] $productosPedidos
 */
class Producto extends \yii\db\ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $imageFile;

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
            [['id_categoria', 'nombre'], 'required', 'message' => Yii::t('app','Este campo no puede estar vacio.')],
            [['id_categoria'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['imagen'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 200],
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['categoria.nombre']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_categoria' => Yii::t('app', 'Categoria'),
            'nombre' => Yii::t('app', 'Nombre'),
            'imagen' => Yii::t('app', 'Imagen'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'imageFile' => Yii::t('app', 'Subir Imagen'),
            'categoria.nombre' => Yii::t('app', 'Categoria'),
        ];
    }

    public function upload()
    {
        $imageUp = new UploadForm();
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $imageUp->imageFile = $this->imageFile;

        if ($imageUp->validate()) {
            $this->imagen = $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs('uploads/productos/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->imageFile = null;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosComercioStock()
    {
        return $this->hasMany(ProductoComercioStock::className(), ['id_producto' => 'id'] );
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
