<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use backend\models\Comercio;
use Yii;

class RutasController extends ActiveController {

    public $modelClass = 'backend\models\Ruta';

    public function behaviors() {
	    return parent::behaviors();
	}

    public function actionObtenerruta(){
        $idRelevador = Yii::$app->request->get('id_relevador');
        if(!empty($idRelevador)){

        }

    }

}