<?php

use yii\grid\GridView;
use app\assets\RutaAsset;

RutaAsset::elegirRelevadorAsset();
RutaAsset::register($this);

?>
<div class="box box-solid box-success">
    <div class="box-body">
        <div class="col-md-5">
            <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'multiple' => false,
                            'name' => 'relevadorSeleccionado'
                        ],
                        'user.username'
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
    </div>
</div>