<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rutas_disponibilidad".
 *
 * @property integer $id_ruta
 * @property integer $id_disponibilidad
 *
 * @property Disponibilidad $idDisponibilidad
 * @property Rutas $idRuta
 */
class RutasDisponibilidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rutas_disponibilidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ruta', 'id_disponibilidad'], 'required'],
            [['id_ruta', 'id_disponibilidad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ruta' => Yii::t('app', 'Id Ruta'),
            'id_disponibilidad' => Yii::t('app', 'Id Disponibilidad'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDisponibilidad()
    {
        return $this->hasOne(Disponibilidad::className(), ['id' => 'id_disponibilidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRuta()
    {
        return $this->hasOne(Rutas::className(), ['id' => 'id_ruta']);
    }
}
