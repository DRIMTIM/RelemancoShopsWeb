<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BuscarCategoria */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-index">

    <div class="box box-warning">

        <div class="box-header" style="border-bottom: solid 1px #D0D0D0; margin: 1%">
            <h1 class="box-title" ><?= Html::encode($this->title) ?></h1>
            <div style="float: right">
                <?= Html::a('Crear Categoria', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="box-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'nombre',
                    'descripcion',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>

    </div>

</div>
