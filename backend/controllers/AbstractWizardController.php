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

class AbstractWizardController extends Controller {

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
    public $TYPE_RESULT = [
        'INFO' => 'info',
        'DANGER' => 'danger',
        'WARNING' => 'warning',
        'SUCCESS' => 'success'
    ];

    public function init(){
        $this->VIEW_CONFIG = [
            'subtitle' => null,
            'actions' => null,
            'partialView' => null,
            'isForm' => null,
            'formAction' => null,
            'formMethod' => null,
            'formOptions' => null,
            'container' => [
                'errores' => [],
                'resultado' => []
            ]
        ];
    }

    public function setViewConfig($subtitle, $actions, $partialView, $isForm, $formAction, $formMethod, $formOptions, $container){
        $this->setViewConfigSubtitle($subtitle);
        $this->setViewConfigActions($actions);
        $this->setViewConfigPartialView($partialView);
        $this->setViewConfigIsForm($isForm);
        $this->setViewConfigFormAction($formAction);
        $this->setViewConfigFormMethod($formMethod);
        $this->setViewConfigContainer($container);
        $this->setViewConfigFormOptions($formOptions);
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

    public function setViewConfigErrores($errores){
        if(!empty($errores)){
            $errores = array_merge($this->VIEW_CONFIG['container']['errores'], $errores);
            $this->VIEW_CONFIG['container']['errores'] = $errores;
        }
    }

    public function setViewConfigFormOptions($formOptions){
        if(!empty($formOptions)){
            $options = ['onsubmit' => 'javascript:blockScreenOnAction()'];
            $options = array_merge($options, $formOptions);
            $this->VIEW_CONFIG['formOptions'] = $options;
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

    public function actionWizard($isError = false){

        $step = $this->getStep();
        $request = null;

        if($isError){
            $step = $step - 1;
        }

        if($this->isBackStep() && $step != -1){
            if(isset(Yii::$app->session[AbstractWizardController::$ACTION_STEPS[$step]])){
                $request = Yii::$app->session[AbstractWizardController::$ACTION_STEPS[$step]];
            }else{
                foreach(AbstractWizardController::$ACTION_STEPS as $stepField){
                    Yii::$app->session->remove($stepField);
                }
                $this->actionIndex();
            }
        }else if($step != -1 && !$isError){
            Yii::$app->session[AbstractWizardController::$ACTION_STEPS[$step]] = Yii::$app->request;
            $request = Yii::$app->request;
        }else if($isError){
            $request = Yii::$app->session[AbstractWizardController::$ACTION_STEPS[$step]];
        }else{
            return $this->actionIndex();
        }

        $actionName = AbstractWizardController::$ACTION_STEPS[$step];

        if(!$isError) {
            $prevStepError = $this->validateActionIfExists($request, $actionName);
            if (!empty($prevStepError)) {
                return $prevStepError;
            }
        }

        $this->setViewConfig(null, $this->fillStepsConfig($step), null, null, null, null, ['id' => '_id_form_step_' . $step], null);

        if(method_exists($this, $actionName)){
            try{
                $content = $this->$actionName($request);
                if(!empty($content)){
                    return $content;
                }else {
                    return $this->renderWizard();
                }
            }catch (Exception $e){
                echo var_dump($e);
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
                    $errores = $this->$validatorName($request);
                    $this->setViewConfigErrores($errores);
                    if(!empty($errores)){
                        return $this->actionWizard(true);
                    }
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

    public function setResultMessage($content, $type){
        if(!empty($content) && !empty($type)){
            $this->setViewConfigSubtitle('Resultado');
            $this->setViewConfigPartialView('_resultado');
            $this->VIEW_CONFIG['container']['resultado']['type'] = $type;
            $this->VIEW_CONFIG['container']['resultado']['content'] = $content;
        }
    }

}
