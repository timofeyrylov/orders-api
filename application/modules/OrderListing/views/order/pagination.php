<?php

use app\thesaurus\codes\PaginationThesaurus as ApplicationPagination;
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
        <?= Yii::t('application', ApplicationPagination::To->value) ?>
        <?= $pagination->getOffset() + $pagination->getLimit() ?>
        <?= Yii::t('application', ApplicationPagination::From->value) ?>
        <?= $totalAmount ?>
    </div>
</div>