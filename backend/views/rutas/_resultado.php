<?php

use yii\grid\GridView;
use \app\assets\RutaAsset;

?>

<div>
    <div class="alert alert-<?php echo $resultado['type'] ?> fade in">
        <?php echo $resultado['content']; ?>
    </div>
</div>