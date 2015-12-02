<?php

use app\assets\RutaAsset;
use backend\widgets\duallistbox\DualListBoxWidget;
use yii\grid\GridView;
use yii\bootstrap\Html;

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
    </div>
</div>