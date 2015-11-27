<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class RelevadoresController extends ActiveController
{
    public $modelClass = 'dektrium\user\models\User';

    public function behaviors()
	{
	    $behaviors = parent::behaviors();
	    /*$behaviors['authenticator'] = [
	        'class' => HttpBasicAuth::className(),
	        'class' => HttpBearerAuth::className()
	    ];*/

	    return $behaviors;
	}




}
