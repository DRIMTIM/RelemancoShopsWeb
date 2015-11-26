<?php

namespace app\assets;

use yii\web\AssetBundle;

class PedidoAsset extends AssetBundle {

    public $js = [];

    public function init() {
        $this->js = [
            'js/magnificPopup.js',
            'js/relemanco/pedidos/pedidos.js',
            'plugins/input-mask/jquery.inputmask.js',
            'plugins/input-mask/jquery.inputmask.date.extensions.js',
            'plugins/input-mask/jquery.inputmask.extensions.js',
        ];
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/estiloPedido.css',
        'css/magnificPopup.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
