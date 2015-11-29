<?php

namespace backend\models;

use dektrium\user\models\User;
use Yii;

/**
 * This is the model class for table "relevadores".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $id_localizacion
 *
 * @property AgendaComercios[] $agendaComercios
 * @property Profile $user
 * @property Localizacion $idLocalizacion
 * @property RutasRelevadorComercio[] $rutasRelevadorComercios
 */
class Relevador extends \yii\db\ActiveRecord
{

    public $rules = [
        [['user_id'], 'required'],
        [['user_id', 'id_localizacion'], 'integer']
    ];

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
    public function rules() { return $this->rules; }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'id_localizacion' => Yii::t('app', 'Id Localizacion'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
    public function getRutasRelevadorComercios()
    {
        return $this->hasMany(RutasRelevadorComercio::className(), ['id_relevador' => 'id']);
    }
}
