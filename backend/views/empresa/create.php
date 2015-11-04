<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = Yii::t('app', 'Create Empresa');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Empresas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-create col-md-8 row">

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
