<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contratos".
 *
 * @property integer $id
 * @property integer $id_empresa
 * @property integer $id_comercio
 * @property string $fecha_desde
 * @property string $fecha_hasta
 *
 * @property Empresas $idEmpresa
 * @property Comercios $idComercio
 */
class Contrato extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contratos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_empresa', 'id_comercio'], 'required'],
            [['id_empresa', 'id_comercio'], 'integer'],
            [['fecha_desde', 'fecha_hasta'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_empresa' => 'Id Empresa',
            'id_comercio' => 'Id Comercio',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpresa()
    {
        return $this->hasOne(Empresas::className(), ['id' => 'id_empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComercio()
    {
        return $this->hasOne(Comercios::className(), ['id' => 'id_comercio']);
    }
}
