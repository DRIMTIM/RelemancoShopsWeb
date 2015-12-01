<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "estados".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 */
class Estado extends \yii\db\ActiveRecord {

    public static $RELEVADA = 'RELEVADA';
    public static $ASIGNADO = 'ASIGNADO';
    public static $DISPONIBLE = 'DISPONIBLE';
    public static $RELEVADO = 'RELEVADO';
    public static $PENDIENTE = 'PENDIENTE';

    public static function findEstadoByNombre($nombreEstado){
        return Estado::find()->where('nombre="' . $nombreEstado . '"')->one();
    }

    public static function tableName() {
        return 'estados';
    }

    public function rules() {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
            [['descripcion'], 'string', 'max' => 200]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }
}
