<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\assets\RelevadorAsset;
use backend\controllers\RelevadorController;

/* @var $this yii\web\View */
/* @var $relevador app\models\Relevador */
/* @var $localizacion app\models\Localizacion */

$this->title = Yii::t('app', 'Asignar Localizacion');
$this->params['breadcrumbs'][] = $this->title;

RelevadorAsset::register($this);

?>
<div class="relevador-index col-md-5 row">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <i class="fa fa-map-marker"></i><h1 class="box-title"><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <div class="box-body">

            <div class="relevador-form">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <div>
                        <?= $form->field($relevador, 'id')->dropdownList(RelevadorController::getAll(), ['prompt' => Yii::t('app', 'Seleccione un Relevador...')]) ?>
                    </div>

                    <div class="box box-warning bg-gray">

                        <div class="box-header">
                            <h1 class="box-title"><i class="fa fa-globe"></i> Localizacion</h1>
                        </div>

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
                        <?= Html::a(Yii::t('app', 'Asignar Localizacion'), [''], ['class' => 'btnAsignarLoc btn btn-success']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>
        <div id="mensajesModal"><h3></h3></div>
    </div>
</div>

<div class="relevador-create col-md-7 pull-right">
    <div id="map" class="box box-solid box-warning"></div>
</div>
