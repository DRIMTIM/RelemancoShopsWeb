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
?>
<div class="ruta-index">

    <div class="box box-solid box-warning">

        <div class="box-header">
                <i class="btn pull-left fa fa-globe "><h1 class="box-title">&nbsp;&nbsp;<?= Html::encode($this->params['listTitle']) ?></h1></i>
            <?= Html::a(Yii::t('app', 'Asignar Ruta'), ['wizard?' . RutasController::$ACTION_STEP . '=0'], ['class' => 'btn btn-success pull-right']) ?>
        </div>

        <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'fecha_asignada',
                    'id_estado',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>

    </div>

</div>