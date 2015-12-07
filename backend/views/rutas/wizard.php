<?php

use yii\helpers\Html;
use backend\controllers\RutasController;

/* @var $this yii\web\View */
/* @var $model app\models\Ruta */

$this->title = Yii::t('app', 'Asignar Ruta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if($isForm) echo Html::beginForm($formAction, $formMethod, $formOptions);

if(!empty($container['errores'])){
    foreach($container['errores'] as $error) {
        ?>
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert" style="text-decoration: none !important;">&times;</a>
            <strong><?php echo Yii::t('app', 'Error!') ?></strong>&nbsp;<?php echo $error ?>
        </div>
        <?php
    }
}

?>

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
    <?php
        $style = null;
        if(!empty($container['resultado'])){
            $style = 'text-align: center;';
        }
    ?>
    <div class="box-footer" style="<?php echo $style; ?>" >
        <?php
            if(empty($container['resultado'])) {
                if (empty($actions) || empty($partialView)) {
                    echo Html::a(Yii::t('app', 'Volver'), ['wizard?' . RutasController::$ACTION_STEP . '=-1'], ['class' => 'btn btn-success pull-left', 'onclick' => 'javascript:blockScreenOnAction()']);
                } else {
                    echo Html::a(Yii::t('app', 'Atrás'), ['wizard?' . RutasController::$ACTION_STEP . '=' . $actions['prevStep'] . '&' . RutasController::$BACK_STEP . '=true'], ['class' => 'btn btn-success pull-left', 'onclick' => 'javascript:blockScreenOnAction()']);
                    if ($isForm)
                        echo Html::submitButton(Yii::t('app', 'Siguiente'), ['class' => 'btn btn-success pull-right']);
                    else
                        echo Html::a(Yii::t('app', 'Siguiente'), ['wizard?' . RutasController::$ACTION_STEP . '=' . $actions['nextStep']], ['class' => 'btn btn-success pull-right']);
                }
            }else{
                echo Html::a(Yii::t('app', 'Aceptar'), ['wizard?' . RutasController::$ACTION_STEP . '=-1'], ['class' => 'btn btn-success']);
            }
        ?>
    </div>
</div>
<?php if($isForm) echo Html::endForm(); ?>