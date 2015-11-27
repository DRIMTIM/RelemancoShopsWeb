<?php

namespace backend\controllers;

use backend\models\BuscarComercio;
use backend\models\BuscarRelevador;
use backend\models\BuscarRutas;
use backend\models\Comercio;
use backend\models\Relevador;
use backend\models\RutasDataProvider;
use backend\models\RutasSearchModel;
use Yii;
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
        $relevador = $relevador->find()->where(['id' => $idRelevador])->with('idLocalizacion')->one();
        $response = new Json();
        $response->localizacionRelevador = $relevador->idLocalizacion;
        $response->relevador = $relevador;
        $response->comercios = $comercios;
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
        RutasController::$ACTION_STEPS = ["actionEligeRelevador", "actionElegirComercio", "actionArmarRuta"];
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

        $this->setViewConfigSubtitle('Elija un Relevador');
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

        $this->setViewConfigSubtitle('Elija Comercios para el Relevador');
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

        $this->setViewConfigSubtitle('Elija la Ruta');
        $this->setViewConfigPartialView('_armarRuta');
        $this->setViewConfigContainer([
            'dataProvider' => $dataProvider
        ]);
    }

}
