<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categoria */

$this->title = Yii::t('app', 'Create Categoria');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-create col-md-8 row">

    <div class="box box-solid box-warning">

        <div class="box-header with-border">
            <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>

    <div>
</div>
