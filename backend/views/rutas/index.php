<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\controllers\RutasController;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RutaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rutas');
$this->params['listTitle'] = Yii::t('app', 'Rutas Asignadas');
$this->params['asignarTitle'] = Yii::t('app', 'Asignar Rutas');
$this->params['breadcrumbs'][] = $this->title;

if(!empty($errores)){
    foreach($errores as $error) {
        ?>
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert" style="text-decoration: none !important;">&times;</a>
            <strong><?php echo Yii::t('app', 'Error!') ?></strong>&nbsp;<?php echo $error ?>
        </div>
        <?php
    }
}

?>
<div class="ruta-index">

    <div class="box box-solid box-warning">

        <div class="box-header">
                <i class="btn pull-left fa fa-globe "><h1 class="box-title">&nbsp;&nbsp;<?= Html::encode($this->params['listTitle']) ?></h1></i>
            <?= Html::a(Yii::t('app', 'Asignar Ruta'), ['wizard?' . RutasController::$ACTION_STEP . '=0'], ['class' => 'btn btn-success pull-right', 'onclick' => 'javascript:blockScreenOnAction()']) ?>
        </div>

        <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'info.id_relevador',
                    'fecha_asignada',
                    [
                        'attribute' => 'estado.nombre',
                        'format' => 'text',
                        'label' => Yii::t('app', 'Estado')
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}'
                    ],
                ],
            ]); ?>

        </div>

    </div>

</div>