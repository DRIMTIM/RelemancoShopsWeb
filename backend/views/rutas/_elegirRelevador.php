<?php

use yii\grid\GridView;

echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'multiple' => false,
                'name' => 'relevadorSeleccionado'
            ],
            'id',
            'user_id',
            'id_localizacion'
        ],
        'rowOptions'=>function($model, $key, $index, $gridView){
            if(!is_integer($index / 2)){
                return ['class' => 'info'];
            }
        },
    ]);

?>