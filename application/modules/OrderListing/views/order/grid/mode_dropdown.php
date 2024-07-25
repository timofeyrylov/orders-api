<?php

use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use OrderListing\thesaurus\ModeThesaurus;
use yii\helpers\Url;

?>

<div class="dropdown">
    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <?= Yii::t('orders', OrdersColumn::Mode->value) ?>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <?php foreach (ModeThesaurus::cases() as $mode): ?>
            <li <?php if (Yii::$app->request->get('mode') === $mode->value): ?>class="active"<?php endif; ?>>
                <a href="<?= Url::current(['mode' => $mode->value]) ?>">
                    <?= $mode->name ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>