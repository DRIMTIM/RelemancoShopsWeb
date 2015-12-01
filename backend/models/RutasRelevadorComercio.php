<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 29/11/15
 * Time: 06:42 PM
 */

namespace backend\models;


use yii\db\ActiveRecord;

class RutasRelevadorComercio extends ActiveRecord {

    public static function tableName() {
        return 'rutasRelevadorComercio';
    }

    public function rules() {
        return [
            [['id_ruta', 'id_relevador', 'id_comercio'], 'required'],
            [['id_ruta', 'id_relevador', 'id_comercio'], 'integer'],
            [['fecha_relevada'], 'safe']
        ];
    }

    public function attributeLabels() {
        return [
            'id_ruta'=> Yii::t('app', 'ID Ruta'),
            'id_relevador'=> Yii::t('app', 'ID Relevador'),
            'id_comercio'=> Yii::t('app', 'ID Comercio')
        ];
    }

    public function getRuta() {
        return $this->hasOne(Ruta::className(), ['id' => 'id_ruta']);
    }

    public function getRutaDia() {
        return $this->hasOne(Ruta::className(), ['id' => 'id_ruta'])->where("DATE(fecha_asignada) = curdate()");
    }

    public function getRutaHistorica() {
        return $this->hasOne(Ruta::className(), ['id' => 'id_ruta'])->where("DATE(fecha_asignada) <= curdate()")->with('estado');
    }

    public function getRelevador() {
        return $this->hasOne(Relevador::className(), ['id' => 'id_relevador']);
    }

    public function getComercio() {
        return $this->hasOne(Comercio::className(), ['id' => 'id_comercio']);
    }

}