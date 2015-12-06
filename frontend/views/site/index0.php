<?php

use frontend\assets\SiteAsset;

/* @var $this yii\web\View */

$this->title = 'RelemancoShops.com';

SiteAsset::register($this);

?>
<div class="site-index">

    <div class="col-md-12 row">
        <div class="box box-solid box-warning">

            <div class="box-header">
                <h1 class="box-title">Mapa de Comercios</h1>
            </div>

            <div class="box-body" id="mapa-comercios">
            </div>

        </div>
    </div>

</div>
