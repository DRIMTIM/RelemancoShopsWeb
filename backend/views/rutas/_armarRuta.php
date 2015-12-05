<?php

use app\assets\RutaAsset;
use backend\widgets\duallistbox\DualListBoxWidget;
use yii\grid\GridView;
use yii\bootstrap\Html;
use backend\models\RutasSearchModel;

RutaAsset::armarRutaAsset();
RutaAsset::register($this);

?>

<div class="col-md-12" style="margin-bottom: 1%;">
    <div class="box box-solid box-success">
        <div class="box-header" style="text-align: center">
            <h1 class="box-title pull-bottom"><?= Html::encode(Yii::t('app', 'Periodicidad de la Ruta')) ?></h1>
        </div>

        <div class="box-body">
            <?php
            echo DualListBoxWidget::widget([
                'model' => $disponibilidadModel,
                'attribute' => 'id',
                'data' => $disponibilidades,
                'data_value'=> 'id',
                'data_text'=> 'nombre',
                'opcionesLenguaje' => [
                    'mostrando_text' => ' - ',
                    'disponible_text' => Yii::t('app', 'Disponibles'),
                    'seleccionado_text' => Yii::t('app', 'Seleccionados')
                ]
            ]);
            ?>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="box box-solid box-success">
        <div class="box-body">
            <div class="col-md-5">

                <?php

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'multiple' => false,
                            'name' => 'comercioSeleccionado'
                        ],
                        'nombre',
                        'prioridad.nombre',
                    ],
                    'rowOptions'=>function($model, $key, $index, $gridView){
                        if(!is_integer($index / 2)){
                            return ['class' => 'info'];
                        }
                    },
                ]);

                ?>
            </div>
            <div id="mapa-ruta" class="col-md-7" style="height: 300pt;"></div>
            <input type="hidden" id="ruta_comercios" name="rutaComercios">
        </div>
        <div class="box-footer" style="text-align: center;">
            <?php echo Html::button(Yii::t('app', 'Calcular Mejor Ruta'), ['class' => 'btn btn-success', 'onclick' => 'javascript:loadBestRoute()']); ?>
            <div id="_cartel_info" class="alert alert-success fade in" style="display: none;margin-top: 1%;">
                <a href="#" class="close" data-dismiss="alert" style="text-decoration: none !important;">&times;</a>
                <strong><?php echo Yii::t('app', 'La ruta fue calculada teniendo en cuenta los siguientes parámetros') ?>:</strong><br>
                <strong><?php echo Yii::t('app', '- Máximo de metros a caminar por el relevador') ?>:</strong>&nbsp;<?php echo RutasSearchModel::$maximaDistanciaRecorrer . Yii::t('app', ' metros.') ?><br>
                <strong><?php echo Yii::t('app', '- Radio límite para el relevador') ?>:</strong>&nbsp;<?php echo RutasSearchModel::$radioPredefinido . Yii::t('app', ' metros.') ?><br>
                <strong><?php echo Yii::t('app', '- Prioridad de los comercios.') ?></strong><br>
                <strong>
                    <p>
                        <?php echo Yii::t('app', 'Algunos comercios pueden quedar fuera de los parámetros por lo que se descartaron, en caso de querer agregarlos puede hacerlo seleccionandolos pero no garantizamos que la ruta sea la más optima.') ?>
                    </p>
                </strong>
            </div>
        </div>
    </div>
</div>