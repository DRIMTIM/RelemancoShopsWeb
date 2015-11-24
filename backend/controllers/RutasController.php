<?php

namespace backend\controllers;

use backend\models\BuscarComercio;
use backend\models\BuscarRelevador;
use backend\models\BuscarRutas;
use backend\models\Relevador;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

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

    public function actionWizard(){
        $step = Yii::$app->request->get(RutasController::$ACTION_STEP, -1);
        if($step == -1)
            $step = Yii::$app->request->post(RutasController::$ACTION_STEP, -1);
        switch($step){
            case 0:
                return $this->actionEligeRelevador();
            case 1:
                return $this->actionElegirComercio();
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

    /**
     * Lists all Ruta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuscarRutas();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Ruta models.
     * @return mixed
     */
    public function actionEligeRelevador(){
        $searchModel = new BuscarRelevador();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
    public function actionElegirComercio(){
        $searchModel = new BuscarComercio();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $condition = intval(Yii::$app->request->post('relevadorSeleccionado')[0]);
        $relevadorSeleccionado = Relevador::findOne($condition);
        return $this->render('wizard', [
            'subtitle' => Yii::t('app', 'Elija Comercios para el Relevador'),
            'actions' => $this->fillStepsConfig(1),
            'partialView' => '_elegirComercio',
            'isForm' => true,
            'formAction' => 'wizard?actionStep=2',
            'formMethod' => 'post',
            'container' => [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'relevadorSeleccionado' => $relevadorSeleccionado
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
