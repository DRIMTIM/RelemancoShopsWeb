<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Relevador */

$this->title = Yii::t('app', 'Create Relevador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relevadors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relevador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
