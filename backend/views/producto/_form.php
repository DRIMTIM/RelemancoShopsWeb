<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\controllers\CategoriaController;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_categoria')->dropdownList(CategoriaController::findAll(), ['prompt' => Yii::t('app', 'Seleccione una Categoria')]) ?>

    <input id="uploadFile" placeholder=" Eliga una imagen..." disabled="disabled" />
    <div class="fileUpload btn btn-warning">
        <?= $form->field($model, 'imageFile')->fileInput(['class' => 'upload']) ?>
    </div>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
