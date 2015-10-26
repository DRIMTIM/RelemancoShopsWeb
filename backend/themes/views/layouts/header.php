<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
$profile = isset($this->params['profile']) ? $this->params['profile'] : null;
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">RMS</span><span class="logo-lg">' . "RelemancoShops" . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <?php if (!Yii::$app->user->getIsGuest()) :?>

            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/> -->
                        <img src="http://gravatar.com/avatar/<?= isset($profile) ?  $profile->gravatar_id : -1?>?s=160" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?php if (!Yii::$app->user->getIsGuest()) echo Yii::$app->user->identity->username; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="http://gravatar.com/avatar/<?= isset($profile) ? $profile->gravatar_id : -1 ?>?s=160" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?php if (!Yii::$app->user->getIsGuest()) echo Yii::$app->user->identity->username; ?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Salir',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>

            <?php endif ?>
        </div>
    </nav>
</header>
