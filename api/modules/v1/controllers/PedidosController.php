<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

use backend\models\Comercio;
use backend\models\Pedido;
use backend\models\ProductoPedido;
use backend\models\ProductoComercioStock;

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

        if(isset($jsonPOST['id_comercio'])){
            $comercio = Comercio::findOne($jsonPOST['id_comercio']);

            if(isset($jsonPOST['productos'])){
                $productos = $jsonPOST['productos'];
                $pedido = new Pedido();
                $pedido->id_comercio = $jsonPOST['id_comercio'];
                $pedido->fecha_realizado = $this->formatoFecha(null);
                $pedido->save();
                $i = 0;

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
                    $i++;
                }

            }
            $item = "";
            return $item;
        }

    }

    public function actionRelevarStockComercio(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(isset($_POST['id_comercio'])){
            $comercio = Comercio::findOne($_POST['id_comercio']);

            if(isset($_POST['productos'])){
                $productos = $_POST['productos'];
                $cantidades = $_POST['cantidades'];
                $i = 0;

                foreach ($productos as $producto) {
                    $prodComStock = ProductoComercioStock::find()->where([
                                                            'id_comercio' => $comercio->id,
                                                            'id_producto' => $productos[$i]
                                                        ])->one();
                    $prodComStock->cantidad = $cantidades[$i];
                    $prodComStock->save();
                    $i++;
                }
            }
            $item = $_POST['productos'];
            return $item;
        }

    }


}
