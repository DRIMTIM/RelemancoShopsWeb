<?php

use yii\grid\GridView;
use \app\assets\RutaAsset;

RutaAsset::register($this);

?>

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
<div id="mapa-ruta" class="col-md-7" style="height: 500pt;"></div>
