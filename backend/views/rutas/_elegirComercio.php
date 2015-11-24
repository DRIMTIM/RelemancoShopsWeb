<?php

use yii\grid\GridView;
echo 'ID DEL RELEVADOR SELECCIONADO =>' . $relevadorSeleccionado->id;
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'multiple' => false
            ],
            'id',
            'id_prioridad',
            'nombre',
            'localizacion',
            'prioridad.nombre'
        ],
        'rowOptions'=>function($model, $key, $index, $gridView){
            if(!is_integer($index / 2)){
                return ['class' => 'info'];
            }
        },
    ]);

?>