<?php

use yii\web\View;

/**
 * @var View $this
 * @var string $id
 * @var string $size
 */
?>
<div class="modal fade bd-example-modal-<?= $size ?>" id="<?= $id ?>" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel"
     aria-hidden="true" >
    <div class="modal-dialog modal-<?= $size ?>" >
        <div class="modal-content">
            <div class="modal-body" style="display: inline-block; min-width: 100%;">
            </div>
        </div>
    </div>
</div>