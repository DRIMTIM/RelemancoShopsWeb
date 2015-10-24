<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "administradores".
 *
 * @property integer $id
 * @property integer $id_estado
 * @property string $apellido
 * @property string $email
 * @property string $fechaNac
 * @property string $nombre
 * @property string $pass
 * @property string $celular
 *
 * @property Estados $idEstado
 */
class Administrador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'administradores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estado', 'apellido', 'email', 'nombre', 'pass', 'celular'], 'required'],
            [['id_estado'], 'integer'],
            [['fechaNac'], 'safe'],
            [['apellido'], 'string', 'max' => 80],
            [['email', 'nombre'], 'string', 'max' => 50],
            [['pass'], 'string', 'max' => 32],
            [['celular'], 'string', 'max' => 20],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_estado' => 'Id Estado',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'fechaNac' => 'Fecha Nac',
            'nombre' => 'Nombre',
            'pass' => 'Pass',
            'celular' => 'Celular',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado()
    {
        return $this->hasOne(Estados::className(), ['id' => 'id_estado']);
    }
}
