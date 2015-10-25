<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rutas".
 *
 * @property integer $id
 * @property string $fecha_asignada
 * @property integer $id_estado
 *
 * @property RutasRelevadorComercio[] $rutasRelevadorComercios
 */
class Ruta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rutas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_asignada'], 'safe'],
            [['id_estado'], 'required'],
            [['id_estado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_asignada' => 'Fecha Asignada',
            'id_estado' => 'Id Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutasRelevadorComercios()
    {
        return $this->hasMany(RutasRelevadorComercio::className(), ['id_ruta' => 'id']);
    }
}
