<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class SecurityController extends ActiveController
{

    public function actions()
    {
        $actions = parent::actions();

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        return "cacaaaaaaaaaa";
    }

    public function actionLogin()
    {
        return "cacaaaaaaaaaa";
    }

}
