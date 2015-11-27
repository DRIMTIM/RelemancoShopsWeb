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
class RutasController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public static $ACTION_STEP = "actionStep";
    public static $BACK_STEP = "backStep";
    private static $STEPS = ["step_1", "step_2", "step_3"];

    private function getStep(){
        $step = Yii::$app->request->get(RutasController::$ACTION_STEP, -1);
        $step = intval($step);
        if($step == -1)
            $step = Yii::$app->request->post(RutasController::$ACTION_STEP, -1);
        intval($step);
        return $step;
    }

    private function isBackStep(){
        return Yii::$app->request->get(RutasController::$BACK_STEP, false);
    }

    public function actionWizard(){
        $step = $this->getStep();
        $request = null;

        if($this->isBackStep() && $step != -1){
            if(isset(Yii::$app->session[RutasController::$STEPS[$step]])){
                $request = Yii::$app->session[RutasController::$STEPS[$step]];
            }else{
                foreach(RutasController::$STEPS as $stepField){
                    Yii::$app->session->remove($stepField);
                }
                $this->actionIndex();
            }
        }else if($step != -1){
            Yii::$app->session[RutasController::$STEPS[$step]] = Yii::$app->request;
            $request = Yii::$app->request;
        }

        switch($step){
            case 0:
                return $this->actionEligeRelevador($request);
            case 1:
                return $this->actionElegirComercio($request);
            case 2:
                return $this->actionArmarRuta($request);
            default:
                return $this->actionIndex();
        }
    }

    private function fillStepsConfig($actualStep){
        return [
            'actualStep' => $actualStep,
            'nextStep' => $actualStep + 1,
            'prevStep' => $actualStep - 1
        ];
    }

    public function actionBuscarComerciosSeleccionados(){
        $comerciosSeleccionados = Json::decode(Yii::$app->request->post('comercios_seleccionados', null));
        $searchModel = new RutasSearchModel();
        $comercios = $searchModel->buscarComerciosSeleccionados($comerciosSeleccionados);
        $idRelevador = Yii::$app->session[RutasController::$STEPS[1]]->post('relevadorSeleccionado')[0];
        $relevador = new BuscarRelevador();
        $relevador = $relevador->find()->where(['id' => $idRelevador])->with('idLocalizacion')->one();
        $response = new Json();
        $response->localizacionRelevador = $relevador->idLocalizacion;
        $response->comercios = $comercios;
        return Json::encode($response);
    }

    public function actionArmarRuta($request){
        $searchModel = new BuscarComercio();
        $searchModel->load($request->post());
        $comerciosSeleccionados = Json::decode($searchModel->id);
        $searchModel = new RutasSearchModel();
        $dataProvider = $searchModel->buscarComerciosSeleccionadosDataProvider($comerciosSeleccionados);
        return $this->render('wizard', [
            'subtitle' => Yii::t('app', 'Elija la Ruta'),
            'actions' => $this->fillStepsConfig(2),
            'partialView' => '_armarRuta',
            'isForm' => true,
            'formAction' => 'wizard?actionStep=3',
            'formMethod' => 'post',
            'container' => [
                'dataProvider' => $dataProvider
            ]
        ]);
    }

    public function actionIndex() {
        foreach(RutasController::$STEPS as $stepField){
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
        return $this->render('wizard', [
            'subtitle' => Yii::t('app', 'Elija un Relevador'),
            'actions' => $this->fillStepsConfig(0),
            'partialView' => '_elegirRelevador',
            'isForm' => true,
            'formAction' => 'wizard?actionStep=1',
            'formMethod' => 'post',
            'container' => [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]
        ]);
    }

    /**
     * Lista los comercios mas cercanos a la ubicacion del relevador.
     * @return mixed
     */
    public function actionElegirComercio($request) {
        $idRelevador = intval($request->post('relevadorSeleccionado')[0]);
        $searchModel = new RutasSearchModel();
        $comerciosDisponibles = $searchModel->buscarComerciosEnRadioRelevador($idRelevador);
        $modelo = new BuscarComercio();

        return $this->render('wizard', [
            'subtitle' => Yii::t('app', 'Elija Comercios para el Relevador'),
            'actions' => $this->fillStepsConfig(1),
            'partialView' => '_elegirComercio',
            'isForm' => true,
            'formAction' => 'wizard?actionStep=2',
            'formMethod' => 'post',
            'container' => [
                'comerciosDisponibles' => $comerciosDisponibles,
                'model' => $modelo
            ]
        ]);
    }

//
//    /**
//     * Lists all Ruta models.
//     * @return mixed
//     */
//    public function actionIndex()
//    {
//        $searchModel = new BuscarRutas();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
//
//    /**
//     * Displays a single Ruta model.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
//
//    /**
//     * Creates a new Ruta model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $model = new Ruta();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Updates an existing Ruta model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Deletes an existing Ruta model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }
//
//    /**
//     * Finds the Ruta model based on its primary key value.
//     * If the model is not found, a 404 HTTP exception will be thrown.
//     * @param integer $id
//     * @return Ruta the loaded model
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    protected function findModel($id)
//    {
//        if (($model = Ruta::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }
}
