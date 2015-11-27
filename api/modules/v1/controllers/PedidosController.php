<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

class PedidosController extends ActiveController
{
    public $modelClass = 'backend\models\Pedido';


	public function behaviors()
	{
	    $behaviors = parent::behaviors();

	    return $behaviors;
	}


}
