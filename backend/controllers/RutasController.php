<?php

namespace backend\controllers;

use backend\models\BuscarComercio;
use backend\models\BuscarDisponibilidad;
use backend\models\BuscarRelevador;
use backend\models\BuscarRuta;
use backend\models\Estado;
use backend\models\Ruta;
use backend\models\RutasDisponibilidad;
use backend\models\RutasRelevadorComercio;
use backend\models\RutasSearchModel;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * RutasController implements the CRUD actions for Ruta model.
 */
class RutasController extends AbstractWizardController {

    public static $DATE_FORMAT = "Y-m-d H:i:s";
    public static $PRIORIDADES = ["URGENTE", "ALTA", "MEDIA", "BAJA"];

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

    public function actionLoadBestRoute(){
        $comerciosParaRuta = Json::decode(Yii::$app->request->post('comercios_disponibles', null));
        $localizacionRelevador = Json::decode(Yii::$app->request->post('localizacion_relevador', null));
        $searchModel = new RutasSearchModel();
        $comercios = $searchModel->obtenerMejorRuta($localizacionRelevador, $comerciosParaRuta);
        $response = new Json();
        $response->comercios = $comercios;
        $response->maximaDistanciaRecorrer = RutasSearchModel::$maximaDistanciaRecorrer;
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
        }else{
            $idRelevador = intval($request->post('relevadorSeleccionado')[0]);
            $searchModel = new RutasSearchModel();
            $comerciosDisponibles = $searchModel->buscarComerciosEnRadioRelevador($idRelevador);
            if(empty($comerciosDisponibles)){
                array_push($errores, Yii::t('app', 'El relevador seleccionado no tiene comercios en su zona!'));
            }
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
        }else {
            $idRelevador = Yii::$app->session[RutasController::$ACTION_STEPS[1]]->post('relevadorSeleccionado')[0];
            $rutasSearchModel = new RutasSearchModel();
            $response = $rutasSearchModel->buscarRutaDelDia($idRelevador);
            if (!empty($response->ruta && $request->post()['BuscarDisponibilidad']['id'] == '[]')) {
                array_push($errores, Yii::t('app', 'Ya existe una ruta para el relevador en el dia de hoy!'));
            }
            if (empty($errores) && !($request->post()['BuscarDisponibilidad']['id'] == '[]')) {
                $searchModel = new BuscarDisponibilidad();
                $searchModel->load(['BuscarDisponibilidad' => $request->post()['BuscarDisponibilidad']]);
                $disponibilidadesSeleccionadas = json_decode($searchModel->id);
                foreach ($disponibilidadesSeleccionadas as $disponibilidad) {
                    $dispSearch = new BuscarDisponibilidad();
                    $disp = $dispSearch->findOne($disponibilidad);
                    $rutasDispSearch = new RutasDisponibilidad();
                    $rutasDisp = $rutasDispSearch->find()->where(['id_disponibilidad' => $disponibilidad])->asArray()->all();
                    $rutasRelevadorComercioSearch = new RutasRelevadorComercio();
                    foreach ($rutasDisp as $rutaDisp) {
                        $rutaExistente = $rutasRelevadorComercioSearch->find()->where(['id_ruta' => $rutaDisp['id_ruta'], 'id_relevador' => $idRelevador])->asArray()->all();
                        if (!empty($rutaExistente)) {
                            array_push($errores, Yii::t('app', 'Ya existe una ruta para el relevador el ' . $disp['nombre'] . '!'));
                            break;
                        }
                    }
                }
            }
        }
        return $errores;
    }

    public function actionIndex($errores = null) {
        foreach(RutasController::$ACTION_STEPS as $stepField){
            Yii::$app->session->remove($stepField);
        }
        $searchModel = new RutasSearchModel();
        $dataProvider = $searchModel->buscarRutas(Yii::$app->request->queryParams);
        $searchModel = $searchModel->getRutaProvider();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'errores' => $errores
        ]);
    }

    public function actionEligeRelevador($request) {
        $searchModel = new RutasSearchModel();
        $dataProvider = $searchModel->buscarRelevadores($request->queryParams);
        $searchModel = $searchModel->getRelevadorProvider();
        $this->setViewConfigSubtitle('Seleccion de Relevador');
        $this->setViewConfigPartialView('_elegirRelevador');
        if($dataProvider->count > 0) {
            $this->setViewConfigContainer([
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        }else{
            return $this->actionIndex([Yii::t('app', 'Debe dar de alta un relevador y asignarle una localizacion primero antes de poder asignar rutas!')]);
        }
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

        $disponibilidades = $searchModel->buscarDisponibilidades();
        $modeloDisponibilidad = new BuscarDisponibilidad();

        $this->setViewConfigSubtitle('Ruta del Día');
        $this->setViewConfigPartialView('_armarRuta');
        $this->setViewConfigContainer([
            'dataProvider' => $dataProvider,
            'disponibilidadModel' => $modeloDisponibilidad,
            'disponibilidades' => $disponibilidades
        ]);
    }

    public function actionAltaRuta($request){
        $idComercios = json_decode($request->post('rutaComercios'));
        $idRelevador = Yii::$app->session[RutasController::$ACTION_STEPS[1]]->post('relevadorSeleccionado')[0];
        $content = null;
        $type = $this->TYPE_RESULT['SUCCESS'];
        try {
            if (!empty($idComercios) && !empty($idRelevador)) {
                $ruta = new Ruta();
                $ruta->setAttribute('id_estado', Estado::findEstadoByNombre(Estado::$DISPONIBLE)->id);
                if($request->post()['BuscarDisponibilidad']['id'] == '[]'){
                   $ruta->setAttribute('fecha_asignada', date(RutasController::$DATE_FORMAT));
                }else{
                    $ruta->setAttribute('fecha_asignada', null);
                }
                $ruta->save();
                $idRuta = $ruta->id;
                foreach ($idComercios as $idComercio) {
                    $infoRuta = new RutasRelevadorComercio();
                    $infoRuta->setAttribute('id_ruta', $idRuta);
                    $infoRuta->setAttribute('id_relevador', $idRelevador);
                    $infoRuta->setAttribute('id_comercio', $idComercio);
                    $infoRuta->save();
                }
                if(!($request->post()['BuscarDisponibilidad']['id'] == '[]')) {
                    $searchModel = new BuscarDisponibilidad();
                    $searchModel->load(['BuscarDisponibilidad' => $request->post()['BuscarDisponibilidad']]);
                    $disponibilidadesSeleccionadas = json_decode($searchModel->id);
                    foreach ($disponibilidadesSeleccionadas as $disponibilidad) {
                        $rutaDisponibilidad = new RutasDisponibilidad();
                        $rutaDisponibilidad->id_ruta = $ruta->id;
                        $rutaDisponibilidad->id_disponibilidad = intval($disponibilidad);
                        $rutaDisponibilidad->save();
                    }
                }else{
                    $rutaDisponibilidad = new RutasDisponibilidad();
                    $rutaDisponibilidad->id_ruta = $ruta->id;
                    $diaActual = jddayofweek(cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y")), 0);
                    $disponibilidad = $diaActual === 0 ? 7 : $diaActual;
                    $rutaDisponibilidad->id_disponibilidad = intval($disponibilidad);
                    $rutaDisponibilidad->save();
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

    /**
     *
     * Acciones que no son controladas por el wizard y que son accedidas directamente (generalemente las del crud).
     *
     */

    public function actionDelete($id) {
        $rutasSearcher = new Ruta();
        $ruta = $rutasSearcher->findOne($id);
        $ruta->delete();
        return $this->redirect(['index']);
    }

}
