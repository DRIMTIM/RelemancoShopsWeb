<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "localizacion".
 *
 * @property integer $id
 * @property double $latitud
 * @property double $longitud
 * @property string $nota
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
            [['latitud', 'longitud'], 'required'],
            [['latitud', 'longitud'], 'number'],
            [['nota'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'latitud' => Yii::t('app', 'Latitud'),
            'longitud' => Yii::t('app', 'Longitud'),
            'nota' => Yii::t('app', 'Nota'),
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
