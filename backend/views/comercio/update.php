<?php

use yii\helpers\Html;
use app\assets\ComercioAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Comercio */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Comercio',
]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comercios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

ComercioAsset::register($this);

?>
<div class="comercio-update col-md-5 row">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
                'localizacion' => $localizacion,
            ]) ?>
        </div>

    </div>

</div>

<div class="comercio-create col-md-7 pull-right">
    <div id="map" class="box box-solid box-warning"></div>
</div>
