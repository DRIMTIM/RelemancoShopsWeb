<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use backend\controllers\ComercioController;
use backend\models\Comercio;
use backend\models\ProductoComercioStock;

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

    public function imagenBase64($nombre){

        $path = "/var/www/html/RelemancoShopsWeb/backend/web/img/productos/" . $nombre;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;

    }

    public function actionObtenerproductos(){

        if(isset($_GET['id_comercio'])){
            $id = $_GET['id_comercio'];
            $model = Comercio::findOne($id);
            if (isset($model)) {
                $result = $model->getProductosComercioStock()->with('producto')->asArray()->all();
                for($i = 0; $i < count($result); $i++){
                    $result[$i]['producto']['imagen'] = $this->imagenBase64($result[$i]['producto']['imagen']);
                }
                return $result;
            }
        }

    }

    public function actionObtenercomercios(){

        $comercio = Comercio::find()->with('localizacion');
        return $comercio->asArray()->all();

    }

}
