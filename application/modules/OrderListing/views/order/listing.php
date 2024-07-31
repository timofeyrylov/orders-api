<?php

use app\thesaurus\codes\TabThesaurus as ApplicationTab;
use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use OrderListing\widgets\Export;
use OrderListing\widgets\grid\Body;
use OrderListing\widgets\grid\Header;
use OrderListing\widgets\grid\ModeDropdown;
use OrderListing\widgets\grid\ServiceDropdown;
use OrderListing\widgets\NavigationBar;
use OrderListing\widgets\Pagination;
use yii\data\Pagination as BasePagination;

$this->title = Yii::t('application', ApplicationTab::Orders->value);
?>
<?php
/** @var BasePagination $pagination */
/** @var array<array> $orders */
/** @var array<array> $services */
?>
<div class="container-fluid">
    <?= NavigationBar::widget() ?>
    <table class="table order-table">
        <?= Header::widget(
            [
                'columns' => [
                    [Yii::t('orders', OrdersColumn::ID->value)],
                    [Yii::t('orders', OrdersColumn::User->value)],
                    [Yii::t('orders', OrdersColumn::Link->value)],
                    [Yii::t('orders', OrdersColumn::Quantity->value)],
                    [ServiceDropdown::widget(['services' => $services]), 'dropdown-th'],
                    [Yii::t('orders', OrdersColumn::Status->value)],
                    [ModeDropdown::widget(), 'dropdown-th'],
                    [Yii::t('orders', OrdersColumn::Created->value)]
                ]
            ]
        ) ?>
        <?= Body::widget(['orders' => $orders]) ?>
    </table>
    <?= Pagination::widget([
        'pagination' => $pagination,
        'totalAmount' => $pagination->totalCount
    ]) ?>
    <?= Export::widget() ?>
</div>

