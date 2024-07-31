<?php

use yii\data\Pagination;
use yii\widgets\LinkPager;

/** @var Pagination $pagination */
/** @var int $totalAmount */
?>

<div class="row">
    <div class="col-sm-8">
        <?= LinkPager::widget(['pagination' => $pagination])?>
    </div>
    <div class="col-sm-4 pagination-counters">
        <?= $pagination->getOffset() + 1 ?>
        <?= Yii::t('application', 'app.pagination.to') ?>
        <?= $pagination->getOffset() + $pagination->getLimit() ?>
        <?= Yii::t('application', 'app.pagination.from') ?>
        <?= $totalAmount ?>
    </div>
</div>