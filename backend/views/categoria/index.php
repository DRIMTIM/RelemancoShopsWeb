<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BuscarCategoria */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categorias');
$this->params['breadcrumbs'][] = $this->title;

// style="border-bottom: solid 1px #D0D0D0; margin: 1%"

?>
<div class="categoria-index">

    <div class="box box-solid box-warning">

        <div class="box-header with-border">
            <h1 class="box-title" ><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="box-body">

            <div class="box-tools" style="float: right;">
                 <?= Html::a(Yii::t('app', 'Create Categoria'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>

            <br/>

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
