<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use backend\controllers\ComercioController;
use backend\models\Comercio;

class ComerciosController extends ActiveController
{
    public $modelClass = 'backend\models\Comercio';

    public function behaviors()
	{
	    $behaviors = parent::behaviors();
	    /*$behaviors['authenticator'] = [
	        'class' => HttpBasicAuth::className(),
	        'class' => HttpBearerAuth::className()
	    ];*/

	    return $behaviors;
	}

    public function actionObtenerproductos(){

        if(isset($_GET['id_comercio'])){
            $id = $_GET['id_comercio'];
            $model = Comercio::findOne($id);
            if (isset($model)) {
                return $model->getProductos()->all();
            }
        }

    }

}
