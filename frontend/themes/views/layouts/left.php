<?php
use yii\bootstrap\Nav;

$profile = isset(Yii::$app->user->identity->profile) ? Yii::$app->user->identity->profile : null;

if (isset(Yii::$app->user->identity)) :
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?php if (!Yii::$app->user->getIsGuest()) :?>
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="http://gravatar.com/avatar/<?= isset($profile) ? $profile->gravatar_id : -1 ?>?s=160" class="img-circle" alt="Imagen de Admin"/>
                </div>
                <div class="pull-left info">
                    <p><?php if (!Yii::$app->user->getIsGuest()) echo Yii::$app->user->identity->username; ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="btn-buscar" class="form-control" placeholder="Buscar..."/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
            </form>
        <!-- /.search form -->
        <?php endif; ?>

        <?=
        Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    '<li class="header">RelemancoShops - Menu</li>',
                    ['label' => '<i class="fa fa-user"></i><span id="perfil-usuario" data-user="' . Yii::$app->user->identity->id  . '" >Perfil</span>',
                        'url' => ['/user/profile/show','id'=>isset(Yii::$app->user->identity) ? Yii::$app->user->identity->id : -1],
                        'visible' =>!Yii::$app->user->isGuest,
                    ],
                ],
            ]
        );
        ?>

    </section>

</aside>
<?php endif; ?>
