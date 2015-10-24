<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "localizacion".
 *
 * @property integer $id
 * @property string $latitud
 * @property string $longitud
 *
 * @property Comercios[] $comercios
 * @property Empresas[] $empresas
 * @property Relevadores[] $relevadores
 */
class Localizacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'localizacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitud', 'longitud'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComercios()
    {
        return $this->hasMany(Comercios::className(), ['id_localizacion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresas::className(), ['id_localizacion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelevadores()
    {
        return $this->hasMany(Relevadores::className(), ['id_localizacion' => 'id']);
    }
}
