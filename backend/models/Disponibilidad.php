<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "disponibilidad".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property RutasDisponibilidad[] $rutasDisponibilidads
 * @property Rutas[] $idRutas
 */
class Disponibilidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disponibilidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutasDisponibilidads()
    {
        return $this->hasMany(RutasDisponibilidad::className(), ['id_disponibilidad' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRutas()
    {
        return $this->hasMany(Rutas::className(), ['id' => 'id_ruta'])->viaTable('rutas_disponibilidad', ['id_disponibilidad' => 'id']);
    }
}
