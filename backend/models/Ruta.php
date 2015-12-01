<?php

namespace backend\models;

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

    public $rules = [
        [['fecha_asignada'], 'safe'],
        [['id_estado'], 'required'],
        [['id_estado'], 'integer']
    ];

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
    public function rules() {
        return $this->rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha_asignada' => Yii::t('app', 'Fecha Asignada'),
            'id_estado' => Yii::t('app', 'Id Estado'),
        ];
    }

    public function getInfo() {
        return $this->hasMany(RutasRelevadorComercio::className(), ['id_ruta' => 'id']);
    }

    public function getEstado() {
        return $this->hasOne(Estado::className(), ['id' => 'id_estado']);
    }

}
