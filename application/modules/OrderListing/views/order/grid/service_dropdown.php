<?php

use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use yii\helpers\Url;

/** @var array<array> $services */

?>

<div class="dropdown">
    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <?= Yii::t('orders', OrdersColumn::Service->value) ?>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li>
            <a href="<?= Url::current(['serviceId' => null]) ?>">
                All (<?= array_sum(array_column($services, 'amount')) ?>)
            </a>
        </li>
        <?php foreach ($services as $model): ?>
            <li
                <?php if (Yii::$app->request->get('serviceId') === $model['id']): ?>
                    class="active"
                <?php elseif (!$model['amount']): ?>
                    class="disabled" aria-disabled="true"
                <?php endif; ?>>
                <a href="<?= Url::current(['serviceId' => $model['id']]) ?>">
                    <span class="label-id"><?= $model['amount'] ?></span> <?= $model['name'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>