<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Pedido */

$this->title = Yii::t('app', 'Create Pedido');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-create">

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
