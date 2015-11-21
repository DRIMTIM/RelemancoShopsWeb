<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class RelevadoresController extends ActiveController
{
    public $modelClass = 'dektrium\user\models\User';

    /**
     * Displays the login page.
     *
     * @return string|Response
     */
    public function actionCustom($params)
    {
        return "Bueno soy una custom action y tengo estos parametros paquete!!!! => " . $params;
    }

}
