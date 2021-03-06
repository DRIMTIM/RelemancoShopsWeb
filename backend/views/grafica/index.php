<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\assets\GraficaAsset;
use backend\controllers\ComercioController;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BuscarProducto */
/* @var $comercios app\models\Comercio */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estadisticas');
$this->params['breadcrumbs'][] = $this->title;

GraficaAsset::register($this);

?>
<div class="grafica-index">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <i class="fa fa-pie-chart"></i><h1 class="box-title"><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <div class="box-body">

            <div class="col-md-12">
                <br/>
                <div class="divGraficas box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Productos mas Vendidos</h3>
                    </div>
                    <br/>
                    <div class="grafica-form">

                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                            <div class="col-md-8">
                                <?= $form->field($comercios, 'id')->dropdownList(ComercioController::getAll(), [
                                                                            'prompt' => Yii::t('app', 'Seleccione un Comercio...')
                                                                        ]) ?>
                            </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                    <br/>
                    <div class="box-body">
                        <div class="chart">
                            <div id='divGraficaProductos'></div>
                        </div>
                    </div>
                </div>

                <div class="divGraficas box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pedidos de Comercios</h3>
                    </div>
                    <br/>
                    <div class="box-body">
                        <div class="chart">
                            <div id='divGraficaPedidos'></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="mensajesModal"><h3></h3></div>

</div>
