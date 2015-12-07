<?php

namespace api\modules\v1\controllers;

use backend\models\Estado;
use backend\models\Ruta;
use backend\models\RutasSearchModel;
use Yii;
use yii\rest\ActiveController;

class RutasController extends ActiveController {

    public $modelClass = 'backend\models\Ruta';

    public function behaviors() {
	    return parent::behaviors();
	}

    public function actionObtenerruta(){
        $idRelevador = Yii::$app->request->get('id_relevador');
        if(!empty($idRelevador)){
            $rutasSearchModel = new RutasSearchModel();
            $response = $rutasSearchModel->buscarRutaDelDia($idRelevador);
            return json_encode($response);
        }else{
            return json_encode(Yii::t('app', 'Debes ingresar un id de relevador!!!'));
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

    public function actionObtenerestadosdisponibles(){
        $estadoSearcher = new Estado();
        $estados = $estadoSearcher->find()->asArray()->all();
        return json_encode($estados);
    }

    public function actionRelevarruta(){
        $ruta = json_decode(Yii::$app->request->get('ruta'));
        if(!empty($ruta)){
            $rutaUpdater = new Ruta();
            $rutaUpdater = $rutaUpdater->findOne($ruta->id);
            $rutaUpdater->id_estado = intval($ruta->estado->id);
            $rutaUpdater->update(true, ['id_estado']);
        }else{
            return json_encode(Yii::t('app', 'Debes enviar la ruta a relevar!!!'));
        }
    }


}
