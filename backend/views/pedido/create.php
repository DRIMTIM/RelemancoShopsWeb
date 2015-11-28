<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\assets\PedidoAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\Pedido */
/* @var $comercio app\models\Comercio */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Create Pedido') . " : " . $comercio->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

PedidoAsset::register($this);

?>
<div class="pedido-create">

    <div class="box box-solid box-warning">
        <div class="box-header">
            <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="box-body">

            <div class="producto-form">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <div>
                        <?= $form->field($model, 'id_comercio')->textInput(['style' => 'display: none;']) ?>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input id="pedido-fecha_realizado" type="text" class="form-control" name="Pedido[fecha_realizado]" data-inputmask='alias': 'dd/mm/yyyy' data-mask>
                        </div>
                    </div>

                    <div style="float: right">
                        <?= Html::a(Yii::t('app', 'Relevar Stock'), [''], ['id' => 'btnRelevarStock', 'class' => 'btnRelevar btn btn-warning']) ?>
                        <?= Html::a(Yii::t('app', 'Confirmar Pedido'), [''], ['id' => 'btnConfirmar', 'class' => 'btnConfirmar btn btn-success']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>

            <br/><br/>

            <div>
                <?= GridView::widget([
                    'id' => 'armarPedidoGrid',
                    'dataProvider' => $dataProvider,
                    'columns' => [

                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            // you may configure additional properties here
                        ],

                        'id',
                        'nombre',
                        'categoria.nombre',

                        [
                            'attribute' => 'cantidad',
                            'value' => function(){
                                return Html::textInput('cantidad', '', [
                                                'class' => 'cantidad form-control input-sm',
                                                'data-inputmask' => "'mask': '9', 'repeat': 10, 'greedy' : false",
                                                'value' => 0]);
                            },
                            'format' => 'raw',
                            'contentOptions' => [
                                'style'=> 'width: 18%;',
                            ],
                        ],

                    ],
                ]); ?>
            </div>

        </div>

    </div>

</div>
