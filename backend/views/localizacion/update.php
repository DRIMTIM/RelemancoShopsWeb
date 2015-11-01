<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Localizacion */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Localizacion',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Localizacions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="localizacion-update">

    <div class="box box-solid box-warning">

        <div class="box-header">
            <h1 class="box-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        
    </div>

</div>
