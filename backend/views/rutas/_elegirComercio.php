<?php

use yii\grid\GridView;
use backend\widgets\duallistbox\DualListBoxWidget;

?>
<div class="box box-solid box-success">
    <div class="box-body">
        <?php
            echo DualListBoxWidget::widget([
                'model' => $model,
                'attribute' => 'id',
                'data' => $comerciosDisponibles,
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
