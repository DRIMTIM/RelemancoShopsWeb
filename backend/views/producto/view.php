<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\ProductoAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Productos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

ProductoAsset::register($this);

?>
<div class="producto-view col-md-6 row">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="box-body">

            <div style="float: right">
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
                    'categoria.nombre',
                    'nombre',
                    'imagen',
                    'descripcion',
                ],
            ]) ?>

        </div>

    </div>

</div>

<div class="producto-create miniaturaProducto col-md-3">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <h1 class="box-title">Imagen del Producto</h1>
        </div>

        <div class="box-body">
            <img class="imagenProducto" src="/RelemancoShopsWeb/backend/web/<?= $model->imagen != null ? "uploads/productos/" . $model->imagen : "img/uploadImg.png" ?>"
                 alt="<?= Yii::t('app', 'Imagen Producto') ?>">
        </div>

    </div>

</div>
