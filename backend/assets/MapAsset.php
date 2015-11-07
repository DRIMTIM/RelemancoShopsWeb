<?php

namespace app\assets;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{

    public $options = [
        'key' => 'AIzaSyCc8qdTE4hoIsnmWLGoGzhp0Djsgck8Kmk',
        'language' => 'es',
        'version' => '3.1.18'
    ];
    public $js = [];

    public function init() {
        $this->js = ['https://maps.googleapis.com/maps/api/js?' . http_build_query($this->options), 'js/relemanco/gmaps/maps.js'];
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/maps.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
