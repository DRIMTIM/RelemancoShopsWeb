<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Prioridad;

/* @var $this yii\web\View */
/* @var $model app\models\Comercio */
/* @var $form yii\widgets\ActiveForm */
/* @var $localizacion app\models\Localizacion */

?>

<div class="comercio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_localizacion')->textInput(['style' => 'display: none;']) ?>

    <?= $form->field($model, 'id_prioridad')->dropdownList(Prioridad::getAll(), ['prompt' => Yii::t('app', 'Seleccione una Prioridad')]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <div class="box box-warning bg-gray">

        <span class="box-header">
            <div class="box-title">
                <i class="fa fa-globe"></i> Localizacion
            </div>
        </span>

        <div class="box-body">
            <?= $form->field($localizacion, 'latitud')->textInput(['readonly' => 'readonly']) ?>
            <span class="info-box-number"></span>
            <hr/>
            <?= $form->field($localizacion, 'longitud')->textInput(['readonly' => 'readonly']) ?>
            <span class="info-box-number"></span>
        </div>

        <?= $form->field($localizacion, 'nota')->textInput(['maxlength' => true,
                                                     'style' => 'display: none;']) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
