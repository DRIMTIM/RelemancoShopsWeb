<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresas".
 *
 * @property integer $id
 * @property integer $id_localizacion
 * @property string $nombre
 * @property string $descripcion
 *
 * @property Contratos[] $contratos
 * @property Localizacion $idLocalizacion
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_localizacion', 'nombre'], 'required'],
            [['id_localizacion'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['descripcion'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_localizacion' => 'Id Localizacion',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratos()
    {
        return $this->hasMany(Contratos::className(), ['id_empresa' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLocalizacion()
    {
        return $this->hasOne(Localizacion::className(), ['id' => 'id_localizacion']);
    }
}
