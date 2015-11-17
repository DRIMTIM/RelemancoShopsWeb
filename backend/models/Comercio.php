<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comercios".
 *
 * @property integer $id
 * @property integer $id_localizacion
 * @property integer $id_prioridad
 * @property string $nombre
 *
 * @property AgendaComercios[] $agendaComercios
 * @property Localizacion $localizacion
 * @property Prioridad $prioridad
 * @property Contratos[] $contratos
 * @property PedidosComercios[] $pedidosComercios
 * @property ProductosComercioStock[] $productosComercioStocks
 * @property Productos[] $productos
 * @property RutasRelevadorComercio[] $rutasRelevadorComercios
 */
class Comercio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_prioridad', 'nombre'], 'required'],
            [['id_localizacion', 'id_prioridad'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['localizacion'], 'required'],
            [['prioridad.nombre'], 'safe'],
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['prioridad.nombre', 'localizacion.nota']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_localizacion' => Yii::t('app', 'Id Localizacion'),
            'id_prioridad' => Yii::t('app', 'Prioridad'),
            'nombre' => Yii::t('app', 'Nombre'),
            'prioridad.nombre' => Yii::t('app', 'Prioridad'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendaComercios()
    {
        return $this->hasMany(AgendaComercios::className(), ['id_comercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacion()
    {
        return $this->hasOne(Localizacion::className(), ['id' => 'id_localizacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrioridad()
    {
        return $this->hasOne(Prioridad::className(), ['id' => 'id_prioridad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contratos::className(), ['id_comercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidosComercios()
    {
        return $this->hasMany(PedidosComercios::className(), ['id_comercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosComercioStocks()
    {
        return $this->hasMany(ProductosComercioStock::className(), ['id_comercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['id' => 'id_producto'])->viaTable('productosComercioStock', ['id_comercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutasRelevadorComercios()
    {
        return $this->hasMany(RutasRelevadorComercio::className(), ['id_comercio' => 'id']);
    }
}
