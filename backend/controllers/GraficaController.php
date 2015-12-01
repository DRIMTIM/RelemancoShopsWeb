<?php

namespace backend\controllers;

use Yii;
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

    public function actionGraficaBarras(){

        if(Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if(isset($_POST['id_comercio'])){
                $id = $_POST['id_comercio'];
                $comercio = Comercio::find()
                    ->select('comercios.id, ventasComercios.id_producto,
                             SUM(ventasComercios.cantidad) as ventas, productos.nombre')
                    ->leftJoin('ventasComercios', '`ventasComercios`.`id_comercio` = `comercios`.`id`')
                    ->leftJoin('productos', '`productos`.`id` = `ventasComercios`.`id_producto`')
                    ->where(['comercios.id' => $id])
                    ->groupBy('comercios.id');

                return $comercio->asArray()->all();
            }
        }
        return "ERROR";
    }

    public function actionGraficaTorta()
    {
        return $this->render('grafica-torta');
    }

}
