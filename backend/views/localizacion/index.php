<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BuscarLocalizacion */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Localizacions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="localizacion-index">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <div class="box-body">

            <div style="float: right">
                <?= Html::a(Yii::t('app', 'Create Localizacion'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>

            <br/><br/>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'latitud',
                    'longitud',
                    'nota',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>

</div>
