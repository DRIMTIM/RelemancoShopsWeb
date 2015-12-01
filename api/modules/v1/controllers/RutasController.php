<?php

namespace api\modules\v1\controllers;

use backend\models\RutasSearchModel;
use yii\helpers\Json;
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
            $rutasSearchModel = new RutasSearchModel();
            $comercios = $rutasSearchModel->buscarRutaDelDia($idRelevador);
            return json_encode($comercios);
        }

    }

    public function actionObtenerhistoricorutas(){
        $idRelevador = Yii::$app->request->get('id_relevador');
        $limite = Yii::$app->request->get('limite');
        $ultimoIdRuta = Yii::$app->request->get('ultimo_id_ruta');
        if(empty($limite)){
            $limite = 10;
        }
        if(empty($ultimoIdRuta)){
            $ultimoIdRuta = -1;
        }
        if(!empty($idRelevador)){
            $rutasSearchModel = new RutasSearchModel();
            $rutasDisponibles = $rutasSearchModel->buscarHistoricoRutas($idRelevador, $limite, $ultimoIdRuta);
            return json_encode($rutasDisponibles);
        }else{
            return json_encode(Yii::t('app', 'Debes ingresar un id de relevador!!!'));
        }

    }


}
