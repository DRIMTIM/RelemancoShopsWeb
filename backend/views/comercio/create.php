<?php

use yii\helpers\Html;
use app\assets\ComercioAsset;
use app\models\Localizacion;


/* @var $this yii\web\View */
/* @var $model app\models\Comercio */
/* @var $localizacion app\models\Localizacion */

$this->title = Yii::t('app', 'Create Comercio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comercios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

ComercioAsset::register($this);

?>
<div class="comercio-create col-md-5 row">

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
