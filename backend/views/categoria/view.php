<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-view col-md-8 row">

    <div class="box box-solid box-warning">

            <div class="box-header with-border">
                <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
            </div>

        <div class="box-body">

            <div class="box-tools" style="float: right">
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>

            </div>

            <br/><br/>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'nombre',
                    'descripcion',
                ],
            ]) ?>

        </div>

    <div>

</div>
