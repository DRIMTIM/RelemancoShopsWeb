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
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Session;

/**
 *
 * Controller Abstract para el manejo de flujos wizard
 *
 * Class AbstractWizardController
 * @package backend\controllers
 */

class AbstractWizardController extends Controller{

    public function behaviors() {
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
    public static $ACTION_STEPS = [];
    public static $DEFAULT_STEP = null;
    private $VIEW_CONFIG = null;

    public function init(){
        $this->VIEW_CONFIG = [
            'subtitle' => null,
            'actions' => null,
            'partialView' => null,
            'isForm' => null,
            'formAction' => null,
            'formMethod' => null,
            'container' => [
                'errores' => null
            ]
        ];
    }

    public function setViewConfig($subtitle, $actions, $partialView, $isForm, $formAction, $formMethod, $container){
        $this->setViewConfigSubtitle($subtitle);
        $this->setViewConfigActions($actions);
        $this->setViewConfigPartialView($partialView);
        $this->setViewConfigIsForm($isForm);
        $this->setViewConfigFormAction($formAction);
        $this->setViewConfigFormMethod($formMethod);
        $this->setViewConfigContainer($container);
    }

    public function setViewConfigContainer($containerArray){
        if(!empty($containerArray)){
            $this->VIEW_CONFIG['container'] = array_merge($this->VIEW_CONFIG['container'], $containerArray);
        }
    }

    public function setViewConfigFormAction($actionLink){
        if(!empty($actionLink)){
            $this->VIEW_CONFIG['formAction'] = $actionLink;
        }else{
            $nextStep = 1;
            if(!empty($this->VIEW_CONFIG['actions'])){
                $nextStep = $this->VIEW_CONFIG['actions']['nextStep'];
            }
            $this->VIEW_CONFIG['formAction'] = 'wizard?actionStep=' . $nextStep;
        }
    }

    public function setViewConfigSubtitle($subtitle){
        if(!empty($subtitle)){
            $this->VIEW_CONFIG['subtitle'] = Yii::t('app', $subtitle);
        }
    }

    public function setViewConfigActions($actions){
        if(!empty($actions)){
            $this->VIEW_CONFIG['actions'] = $actions;
        }else{
            $this->VIEW_CONFIG['actions'] = $this->fillStepsConfig(0);
        }
    }

    public function setViewConfigPartialView($partialView){
        if(!empty($partialView)){
            $this->VIEW_CONFIG['partialView'] = $partialView;
        }else{
            $defaultView = 'index';
            if(!empty(AbstractWizardController::$DEFAULT_STEP)){
                $defaultView = AbstractWizardController::$DEFAULT_STEP;
            }
            $this->VIEW_CONFIG['partialView'] = $defaultView;
        }
    }

    public function setViewConfigIsForm($isForm){
        if(!empty($isForm)){
            $this->VIEW_CONFIG['isForm'] = $isForm;
        }else{
            $this->VIEW_CONFIG['isForm'] = true;
        }
    }

    public function setViewConfigFormMethod($formMethod){
        if(!empty($formMethod)){
            $this->VIEW_CONFIG['formMethod'] = $formMethod;
        }else{
            $this->VIEW_CONFIG['formMethod'] = 'POST';
        }
    }

    public function actionIndex() {
        foreach(AbstractWizardController::$STEPS as $stepField){
            Yii::$app->session->remove($stepField);
        }
        return $this->render('index');
    }

    private function getStep(){
        $step = Yii::$app->request->get(AbstractWizardController::$ACTION_STEP, -1);
        $step = intval($step);
        if($step == -1)
            $step = Yii::$app->request->post(AbstractWizardController::$ACTION_STEP, -1);
        intval($step);
        return $step;
    }

    private function isBackStep(){
        return Yii::$app->request->get(AbstractWizardController::$BACK_STEP, false);
    }

    public function actionWizard(){

        $step = $this->getStep();
        $request = null;

        if($this->isBackStep() && $step != -1){
            if(isset(Yii::$app->session[AbstractWizardController::$ACTION_STEPS[$step]])){
                $request = Yii::$app->session[AbstractWizardController::$ACTION_STEPS[$step]];
            }else{
                foreach(AbstractWizardController::$ACTION_STEPS as $stepField){
                    Yii::$app->session->remove($stepField);
                }
                $this->actionIndex();
            }
        }else if($step != -1){
            Yii::$app->session[AbstractWizardController::$ACTION_STEPS[$step]] = Yii::$app->request;
            $request = Yii::$app->request;
        }else{
            return $this->actionIndex();
        }

        $actionName = AbstractWizardController::$ACTION_STEPS[$step];

        $this->validateActionIfExists($request, $actionName);

        $this->setViewConfig(null, $this->fillStepsConfig($step), null, null, null, null, null);

        if(method_exists($this, $actionName)){
            try{
                $this->$actionName($request);
                return $this->renderWizard();
            }catch (Exception $e){
                return $this->actionIndex();
            }
        }else{
            return $this->actionIndex();
        }
    }

    private function renderWizard(){
        return $this->render('wizard', $this->VIEW_CONFIG);
    }

    private function validateActionIfExists($request, $actionName){
        if(!empty($actionName)){
            $validatorName = 'validate' . substr($actionName, 6);
            if(method_exists($this, $validatorName)){
                try{
                    $this->VIEW_CONFIG['container']['errores'] = array_merge($this->VIEW_CONFIG['container']['errores'], $this->$validatorName($request));
                }catch (Exception $e){}
            }
        }
    }

    private function fillStepsConfig($actualStep){
        return [
            'actualStep' => $actualStep,
            'nextStep' => $actualStep + 1,
            'prevStep' => $actualStep - 1
        ];
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
