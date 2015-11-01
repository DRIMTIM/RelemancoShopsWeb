<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BuscarEmpresa */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Empresas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-index">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <i class="fa fa-institution"></i><h1 class="box-title"><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <div class="box-body">

            <div style="float: right">
                <?= Html::a(Yii::t('app', 'Create Empresa'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>

            <br/><br/>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'id_localizacion',
                    'nombre',
                    'descripcion',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>

</div>
