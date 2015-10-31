<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Categoria: ',
]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="categoria-update col-md-8 row">

    <div class="box box-warning">

        <div class="box-body">

            <div class="box-header" style="border-bottom: solid 1px #D0D0D0; margin: 1%">
                <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
            </div>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>

    </div>

</div>
