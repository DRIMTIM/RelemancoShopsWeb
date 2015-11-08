<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prioridades".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 *
 * @property Comercios[] $comercios
 */
class Prioridad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prioridades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
            [['descripcion'], 'string', 'max' => 100]
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
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComercios()
    {
        return $this->hasMany(Comercios::className(), ['id_prioridad' => 'id']);
    }


    /* Metodos Auxiliares */
    public static function getAll(){

        return Prioridad::find()->select(['nombre', 'id'])->indexBy('id')->column();

    }

}
