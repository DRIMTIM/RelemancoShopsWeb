<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Relevador */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Relevador',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relevadors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="relevador-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
