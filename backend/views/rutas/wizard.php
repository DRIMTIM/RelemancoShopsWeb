<?php

use yii\helpers\Html;
use backend\controllers\RutasController;

/* @var $this yii\web\View */
/* @var $model app\models\Ruta */

$this->title = Yii::t('app', 'Asignar Ruta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if($isForm) echo Html::beginForm($formAction, $formMethod);
?>

<div class="ruta-create">
    <div class="box box-solid box-warning">
        <div class="box-header">
            <h1 class="box-title"><?= Html::encode($subtitle) ?></h1>
        </div>

        <div class="box-body">
            <?php
                if(empty($actions) || empty($partialView)){
                    echo Html::encode(Yii::t('app', 'Ocurrió un error al cargar el wizard!'));
                }else{
                    echo $this->render($partialView, $container);
                }
            ?>
        </div>

        <div class="box-footer">
            <?php
                if(empty($actions) || empty($partialView)){
                    echo Html::a(Yii::t('app', 'Volver'), ['wizard?' . RutasController::$ACTION_STEP . '=-1'], ['class' => 'btn btn-success pull-left']);
                }else{
                    echo Html::a(Yii::t('app', 'Atrás'), ['wizard?' . RutasController::$ACTION_STEP . '=' . $actions['prevStep'] . '&' . RutasController::$BACK_STEP . '=true'], ['class' => 'btn btn-success pull-left']);
                    if($isForm)
                        echo Html::submitButton(Yii::t('app', 'Siguiente'), ['class' => 'btn btn-success pull-right']);
                    else
                        echo Html::a(Yii::t('app', 'Siguiente'), ['wizard?' . RutasController::$ACTION_STEP . '=' . $actions['nextStep']], ['class' => 'btn btn-success pull-right']);
                }
            ?>
        </div>
    </div>
</div>
<?php if($isForm) echo Html::endForm(); ?>