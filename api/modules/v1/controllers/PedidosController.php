<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

use backend\models\Comercio;
use backend\models\Pedido;
use backend\models\ProductoPedido;
use backend\models\ProductoComercioStock;
use backend\models\PedidoRelevador;
use backend\models\VentaComercio;

class PedidosController extends ActiveController
{
    public $modelClass = 'backend\models\Pedido';


	public function behaviors()
	{
	    $behaviors = parent::behaviors();

	    return $behaviors;
	}

    public function formatoFecha($fecha){

        if(!empty($fecha) || $fecha != ''){
            $dateSplit = explode("/", $fecha);
            $hoy = new \DateTime();
            $hoySplit = $hoy->format('Y-m-d H:i:s');
            $hoySplit2 = explode(" ", $hoySplit);
            $date = new \DateTime($dateSplit[2] . "/" . $dateSplit[1] . "/" . $dateSplit[0] . " " . $hoySplit2[1]);
            return $date->format('Y-m-d H:i:s');
        }else{
            $hoy = new \DateTime();
            return $hoy->format('Y-m-d H:i:s');
        }

    }

    public function actionConfirmarPedido(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $jsonPOST = json_decode(file_get_contents('php://input'), true);

        if(isset($jsonPOST['id_comercio']) && isset($jsonPOST['id_relevador'])){
            $comercio = Comercio::findOne($jsonPOST['id_comercio']);

            if(isset($jsonPOST['productos'])){
                $productos = $jsonPOST['productos'];
                $pedido = new Pedido();
                $pedido->id_comercio = $jsonPOST['id_comercio'];
                $pedido->fecha_realizado = $this->formatoFecha(null);
                $pedido->save();

                $pedidoRelevador = new PedidoRelevador();
                $pedidoRelevador->id_relevador = $jsonPOST['id_relevador'];
                $pedidoRelevador->id_pedido = $pedido->id;
                $pedidoRelevador->save();

                foreach ($productos as $producto) {
                    $prodPedido = new ProductoPedido();
                    $prodPedido->id_pedido = $pedido->id;
                    $prodPedido->id_producto = $producto["id"];
                    $prodPedido->cantidad = $producto["cantidad"];
                    $prodComStock = ProductoComercioStock::find()->where([
                                                        'id_comercio' => $pedido->id_comercio,
                                                        'id_producto' => $prodPedido->id_producto
                                                    ])->one();
                    $prodComStock->cantidad += $prodPedido->cantidad;
                    $prodComStock->save();
                    $prodPedido->save();
                }

            }
            $item = "OK";
            return $item;
        }

        return "ERROR";

    }

    public function actionRelevarStockComercio(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $jsonPOST = json_decode(file_get_contents('php://input'), true);

        if(isset($jsonPOST['id_comercio'])){
            $comercio = Comercio::findOne($jsonPOST['id_comercio']);

            if(isset($jsonPOST['productos'])){
                $productos = $jsonPOST['productos'];

                foreach ($productos as $producto) {
                    $ventaComercio = new VentaComercio();
                    $ventaComercio->id_comercio = $comercio->id;
                    $ventaComercio->id_producto = $producto["id"];

                    $prodComStock = ProductoComercioStock::find()->where([
                                                            'id_comercio' => $comercio->id,
                                                            'id_producto' => $producto["id"]
                                                        ])->one();

                    if(($prodComStock->cantidad - $producto['cantidad']) < 0){
                        return "ERROR: " . "Cantidad producto id= " . $producto["id"] . " incorrecta.";
                    }

                    $ventaComercio->cantidad = $prodComStock->cantidad - $producto['cantidad'];
                    $prodComStock->cantidad = $producto['cantidad'];
                    $ventaComercio->save();
                    $prodComStock->save();
                }
            }
            $item = "OK";
            return $item;
        }

        return "ERROR";

    }


}
