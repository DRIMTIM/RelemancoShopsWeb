<?php

namespace backend\controllers;

use Yii;
use backend\models\VentaComercio;
use backend\models\Comercio;
use backend\models\Producto;
use backend\models\Pedido;

class GraficaController extends \yii\web\Controller
{

    public function actionIndex() {

        $comercios = new Comercio();

        return $this->render('index', [
            'comercios' => $comercios,
        ]);

    }

    public function actionGraficaBarrasVentas(){

        if(Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if(isset($_POST['id_comercio'])){
                $id = $_POST['id_comercio'];
                $ventasComercio = VentaComercio::find()
                    ->select('ventasComercios.id, ventasComercios.id_comercio, ventasComercios.id_producto,
                             SUM(ventasComercios.cantidad) as ventas, productos.nombre')
                    ->leftJoin('productos', 'productos.id = ventasComercios.id_producto')
                    ->where(['ventasComercios.id_comercio' => $id])
                    ->groupBy('ventasComercios.id_producto')
                    ->orderBy('ventas');

                return $ventasComercio->asArray()->all();
            }
        }
        return "ERROR";
    }

    public function actionGraficaBarrasPedidos(){

        if(Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $ventasComercio = Pedido::find()
                ->select('pedidos.id_comercio, comercios.nombre, pedidos.fecha_realizado, COUNT(*) as cantidad')
                ->leftJoin('comercios', 'comercios.id = pedidos.id_comercio')
                ->groupBy('pedidos.id_comercio')
                ->orderBy('cantidad');

            return $ventasComercio->asArray()->all();

        }
        return "ERROR";

    }

}
