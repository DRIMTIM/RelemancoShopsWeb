<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relevadores".
 *
 * @property integer $id
 * @property integer $id_estado
 * @property integer $id_localizacion
 * @property string $nombre
 * @property string $apellido
 * @property string $email
 * @property string $fechaNac
 * @property string $timeZone
 * @property string $celular
 * @property string $pass
 *
 * @property AgendaComercios[] $agendaComercios
 * @property Localizacion $idLocalizacion
 * @property Estados $idEstado
 * @property RutasRelevadorComercio[] $rutasRelevadorComercios
 */
class Relevador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relevadores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estado', 'id_localizacion', 'nombre', 'apellido', 'email', 'timeZone', 'celular', 'pass'], 'required'],
            [['id_estado', 'id_localizacion'], 'integer'],
            [['fechaNac'], 'safe'],
            [['nombre', 'apellido', 'email'], 'string', 'max' => 50],
            [['timeZone', 'celular'], 'string', 'max' => 20],
            [['pass'], 'string', 'max' => 32],
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
            'id_localizacion' => 'Id Localizacion',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'fechaNac' => 'Fecha Nac',
            'timeZone' => 'Time Zone',
            'celular' => 'Celular',
            'pass' => 'Pass',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendaComercios()
    {
        return $this->hasMany(AgendaComercios::className(), ['id_relevador' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLocalizacion()
    {
        return $this->hasOne(Localizacion::className(), ['id' => 'id_localizacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado()
    {
        return $this->hasOne(Estados::className(), ['id' => 'id_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutasRelevadorComercios()
    {
        return $this->hasMany(RutasRelevadorComercio::className(), ['id_relevador' => 'id']);
    }
}
