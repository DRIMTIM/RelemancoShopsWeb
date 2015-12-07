<?php

use frontend\assets\SiteAsset;

/* @var $this yii\web\View */

$this->title = 'Histórico de rutas';

SiteAsset::register($this);

?>
<div class="site-index">

    <div class="col-md-12 row">
        <div class="box box-solid box-success">

            <div class="box-header">
                <h1 class="box-title">Mapa</h1>
            </div>

            <div class="box-body" id="mapa-comercios">
            </div>

        </div>
    </div>

    <div class="col-md-12 row">
        <div class="box box-solid box-success">

            <div class="box-body">
                <table id="tabla-filtro-rutas" class="table table-bordered table-hover">
                    <thead>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </thead>
                    <tbody id="tabla-body">

                    </tbody>
                </table>
            </div>


        </div>
    </div>

</div>
