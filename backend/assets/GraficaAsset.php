<?php

namespace app\assets;

use yii\web\AssetBundle;

class GraficaAsset extends AssetBundle {

    public $js = [];

    public function init() {
        $this->js = [
            'js/magnificPopup.js',
            'plugins/chartjs/Chart.js',
            'js/relemanco/graficas/graficas.js',
            'plugins/input-mask/jquery.inputmask.js',
            'plugins/input-mask/jquery.inputmask.date.extensions.js',
            'plugins/input-mask/jquery.inputmask.extensions.js',
            'plugins/input-mask/jquery.inputmask.numeric.extensions.js',
        ];
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/estiloGrafica.css',
        'css/magnificPopup.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
