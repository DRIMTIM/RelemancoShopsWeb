<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BuscarProducto */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Productos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <i class="fa fa-shopping-cart"></i><h1 class="box-title"><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <div class="box-body">

            <div style="float: right">
                <?= Html::a(Yii::t('app', 'Create Producto'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>

            <br/><br/>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'id_categoria',
                    'nombre',
                    'imagen',
                    'descripcion',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>

</div>
