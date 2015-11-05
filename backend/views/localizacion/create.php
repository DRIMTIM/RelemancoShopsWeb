<?php

use yii\helpers\Html;
use app\assets\MapAsset;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;

$coord = new LatLng(['lat' => -34.8059635, 'lng' => -56.2145634]);
$map = new Map([
    'center' => $coord,
    'zoom' => 10,
]);

/* @var $this yii\web\View */
/* @var $model app\models\Localizacion */

$this->title = Yii::t('app', 'Create Localizacion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Localizacions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
MapAsset::register($this);

?>
<div class="localizacion-create col-md-4 row">

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

<div class="localizacion-create col-md-8 pull-right">
    <div id="map" class="box box-solid box-warning">

    </div>
</div>
