<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use dektrium\user\controllers\SecurityController;

use dektrium\user\Finder;
use dektrium\user\models\Account;
use dektrium\user\models\LoginForm;
use dektrium\user\models\User;
use dektrium\user\Module;
use dektrium\user\traits\AjaxValidationTrait;
use Yii;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

use backend\models\Relevador;
use backend\models\Localizacion;

class SecureController extends SecurityController {

    public function actions()
    {
        $actions = parent::actions();

        return $actions;
    }

    public function actionLogin(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        /** @var LoginForm $model */
        $model = Yii::createObject(LoginForm::className());
        $model->rememberMe = 0;

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            $user = $this->finder->findUserByUsernameOrEmail($model->login);
            $relevador = Relevador::find()->where([ 'user_id' => $user->id ])->one();
            $user->id = $relevador->id;
            $localizacion = Localizacion::findOne($relevador->id_localizacion);
            unset($user['password_hash']);
            unset($user['auth_key']);
            $result = [];
            array_push($result, $user);
            array_push($result, $localizacion);
            return $result;
        }

        return false;
    }

}
