<?php

namespace backend\controllers;

use backend\models\VentaComercio;
use backend\models\Comercio;
use backend\models\Producto;

class GraficaController extends \yii\web\Controller
{

    public function actionIndex() {

        $comercios = new Comercio();

        return $this->render('index', [
            'comercios' => $comercios,
        ]);

    }

    public function actionGraficaBarras()
    {
        return $this->render('grafica-barras');
    }

    public function actionGraficaTorta()
    {
        return $this->render('grafica-torta');
    }

}
