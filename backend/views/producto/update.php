<?php

use yii\helpers\Html;
use app\assets\ProductoAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Producto',
]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Productos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

ProductoAsset::register($this);

?>
<div class="producto-update col-md-6 row">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
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
