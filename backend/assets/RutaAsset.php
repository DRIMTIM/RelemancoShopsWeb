<?php

namespace app\assets;

use yii\web\AssetBundle;

class RutaAsset extends AssetBundle {

    public static $static_options = [
        'key' => 'AIzaSyCc8qdTE4hoIsnmWLGoGzhp0Djsgck8Kmk',
        'language' => 'es',
        'version' => '3.1.18'
    ];
    public static $static_js = null;

    public static function armarRutaAsset(){
        RutaAsset::$static_js = [
            'https://maps.googleapis.com/maps/api/js?' . http_build_query(RutaAsset::$static_options),
            'js/relemanco/rutas/rutas.js'
        ];
    }

    public static function elegirRelevadorAsset(){
        RutaAsset::$static_js = [
            'https://maps.googleapis.com/maps/api/js?' . http_build_query(RutaAsset::$static_options),
            'js/relemanco/rutas/relevador.js'
        ];
    }

    public function init(){
        $this->js = RutaAsset::$static_js;
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
