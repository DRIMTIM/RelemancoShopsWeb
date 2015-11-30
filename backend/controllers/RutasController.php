<?php

namespace backend\controllers;

use app\models\Estado;
use backend\models\BuscarComercio;
use backend\models\BuscarRelevador;
use backend\models\BuscarRutas;
use backend\models\Comercio;
use backend\models\Relevador;
use backend\models\Ruta;
use backend\models\RutasDataProvider;
use backend\models\RutasRelevadorComercio;
use backend\models\RutasSearchModel;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Session;

/**
 * RutasController implements the CRUD actions for Ruta model.
 */
class RutasController extends AbstractWizardController {

    /**
     *
     * Acciones que son llamadas desde AJAX, no pasan por las validaciones ni por la logica del wizard.
     *
     */

    public function actionBuscarComerciosSeleccionados() {
        $comerciosSeleccionados = Json::decode(Yii::$app->request->post('comercios_seleccionados', null));
        $searchModel = new RutasSearchModel();
        $comercios = $searchModel->buscarComerciosSeleccionados($comerciosSeleccionados);
        $idRelevador = Yii::$app->session[RutasController::$ACTION_STEPS[1]]->post('relevadorSeleccionado')[0];
        $relevador = new BuscarRelevador();
        $relevador = $relevador->find()->where(['id' => $idRelevador])->with('idLocalizacion')->with('user')->one();
        $response = new Json();
        $response->localizacionRelevador = $relevador->idLocalizacion;
        $response->relevador = $relevador;
        $response->comercios = $comercios;
        $response->user = $relevador->user;
        $response->radioRelevador = RutasSearchModel::$radioPredefinido;
        return Json::encode($response);
    }

    public function actionBuscarRelevadoresForMap() {
        $relevadoresDisponibles = Json::decode(Yii::$app->request->post('relevadores_disponibles', null));
        $searchModel = new RutasSearchModel();
        $relevadores = $searchModel->buscarRelevadoresDisponibles($relevadoresDisponibles);
        $response = new Json();
        $response->relevadores = $relevadores;
        $response->radioRelevador = RutasSearchModel::$radioPredefinido;
        return Json::encode($response);
    }

    /*
     *
     * Acciones que se validan en caso de declarar validadores y ademas son controladas por el wizard con los pasos correspondientes.
     *
     */

    public function init(){
        parent::init();
        RutasController::$ACTION_STEPS = ["actionEligeRelevador", "actionElegirComercio", "actionArmarRuta", "actionAltaRuta"];
    }

    public function validateElegirComercio($request) {
        $errores = [];
        if(empty($request->post('relevadorSeleccionado'))){
            array_push($errores, Yii::t('app', 'Debe elegir un relevador!'));
        }
        return $errores;
    }

    public function validateArmarRuta($request) {
        $errores = [];
        if($request->post()['BuscarComercio']['id'] == '[]'){
            array_push($errores, Yii::t('app', 'Debe elegir al menos un comercio!'));
        }
        return $errores;
    }

    public function validateAltaRuta($request) {
        $errores = [];
        if(empty($request->post('rutaComercios'))){
            array_push($errores, Yii::t('app', 'Debe definir al menos un comercio para la ruta!'));
        }
        return $errores;
    }

    public function actionIndex() {
        foreach(RutasController::$ACTION_STEPS as $stepField){
            Yii::$app->session->remove($stepField);
        }
        $searchModel = new RutasSearchModel();
        $dataProvider = $searchModel->buscarRutas(Yii::$app->request->queryParams);
        $searchModel = $searchModel->getRutaProvider();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEligeRelevador($request) {
        $searchModel = new RutasSearchModel();
        $dataProvider = $searchModel->buscarRelevadores($request->queryParams);
        $searchModel = $searchModel->getRelevadorProvider();

        $this->setViewConfigSubtitle('Seleccion de Relevador');
        $this->setViewConfigPartialView('_elegirRelevador');
        $this->setViewConfigContainer([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionElegirComercio($request) {
        $idRelevador = intval($request->post('relevadorSeleccionado')[0]);
        $searchModel = new RutasSearchModel();
        $comerciosDisponibles = $searchModel->buscarComerciosEnRadioRelevador($idRelevador);
        $modelo = new BuscarComercio();

        $this->setViewConfigSubtitle('Seleccion de Comercios');
        $this->setViewConfigPartialView('_elegirComercio');
        $this->setViewConfigContainer([
            'comerciosDisponibles' => $comerciosDisponibles,
            'model' => $modelo
        ]);
    }

    public function actionArmarRuta($request) {
        $searchModel = new BuscarComercio();
        $searchModel->load($request->post());
        $comerciosSeleccionados = Json::decode($searchModel->id);
        $searchModel = new RutasSearchModel();
        $dataProvider = $searchModel->buscarComerciosSeleccionadosDataProvider($comerciosSeleccionados);

        $this->setViewConfigSubtitle('Ruta del Día');
        $this->setViewConfigPartialView('_armarRuta');
        $this->setViewConfigContainer([
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionAltaRuta($request){
        $idComercios = Json::decode($request->post('rutaComercios'), null);
        $idRelevador = Yii::$app->session[RutasController::$ACTION_STEPS[1]]->post('relevadorSeleccionado')[0];
        $content = null;
        $type = $this->TYPE_RESULT['INFO'];
        try {
            if (!empty($idComercios) && !empty($idRelevador)) {
                $ruta = new Ruta();
                $ruta->setAttribute('id_estado', Estado::findEstadoByNombre(Estado::$DISPONIBLE)->id);
                $ruta->save();
                $idRuta = $ruta->id;
                foreach ($idComercios as $idComercio) {
                    $infoRuta = new RutasRelevadorComercio();
                    $infoRuta->setAttribute('id_ruta', $idRuta);
                    $infoRuta->setAttribute('id_relevador', $idRelevador);
                    $infoRuta->setAttribute('id_comercio', $idComercio);
                    $infoRuta->save();
                }
                $content = Yii::t('app', 'Se ha creado la ruta exitosamente!');
            }else{
                $type = $this->TYPE_RESULT['DANGER'];
                $content = Yii::t('app', 'Ha ocurrido un error al guardar la ruta: ');
            }
        }catch(Exception $e){
            $type = $this->TYPE_RESULT['DANGER'];
            $content = Yii::t('app', 'Ha ocurrido un error al guardar la ruta: ' . $e->getMessage());

        }
        $this->setResultMessage($content, $type);
    }

}
