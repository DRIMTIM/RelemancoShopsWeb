<?php

namespace app\assets;

use yii\web\AssetBundle;

class MapsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/maps.css',
    ];
    public $js = [ 'js/relemanco/gmaps/maps.js', ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
