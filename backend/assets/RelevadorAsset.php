<?php

namespace app\assets;

use yii\web\AssetBundle;

class RelevadorAsset extends AssetBundle
{

    public $options = [
        'key' => 'AIzaSyCc8qdTE4hoIsnmWLGoGzhp0Djsgck8Kmk',
        'language' => 'es',
        'version' => '3.1.18'
    ];
    public $js = [];

    public function init() {
        $this->js = [
            'https://maps.googleapis.com/maps/api/js?' . http_build_query($this->options),
            'js/relemanco/relevadores/relevadores.js',
            'js/magnificPopup.js',
        ];
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/estiloRelevador.css',
        'css/magnificPopup.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
