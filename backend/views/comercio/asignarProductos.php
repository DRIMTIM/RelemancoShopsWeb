<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\assets\ProductoAsset;
use backend\controllers\ComercioController;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BuscarProducto */
/* @var $comercios app\models\Comercio */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Asignar Productos');
$this->params['breadcrumbs'][] = $this->title;

ProductoAsset::register($this);

?>
<div class="producto-index">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <i class="fa fa-shopping-cart"></i><h1 class="box-title"><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <div class="box-body">

            <div class="producto-form">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <div class="col-md-10">
                        <?= $form->field($comercios, 'id')->dropdownList(ComercioController::getAll(), ['prompt' => Yii::t('app', 'Seleccione un Comercio...')]) ?>
                    </div>

                    <div style="float: right">
                        <?= Html::a(Yii::t('app', 'Asignar Productos'), [''], ['class' => 'btnAsignar btn btn-success']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>

            <br/><br/>

            <div>
                <?= GridView::widget([
                    'id' => 'asignarProductosGrid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [

                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            // you may configure additional properties here
                        ],

                        'id',
                        'nombre',
                        'categoria.nombre',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>

        </div>
        <div id="mensajesModal"><h3></h3></div>

</div>
