<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prioridades".
 *
 * @property integer $id
 * @property string $nombre
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
            [['nombre'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComercios()
    {
        return $this->hasMany(Comercios::className(), ['id_prioridad' => 'id']);
    }
}
