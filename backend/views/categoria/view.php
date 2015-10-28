<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-view col-md-8 row">

    <div class="box box-warning">

        <div class="box-body">
            <div class="box-header" style="border-bottom: solid 1px #D0D0D0; margin: 1%">

                <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
                <div style="float: right">
                    <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Esta seguro que quiere eliminar esta Categoria?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>

            </div>

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
