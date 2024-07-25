<?php

use app\thesaurus\codes\TabThesaurus as ApplicationTab;
use OrderListing\components\Export;
use OrderListing\components\grid\Body;
use OrderListing\components\grid\Header;
use OrderListing\components\grid\ModeDropdown;
use OrderListing\components\grid\ServiceDropdown;
use OrderListing\components\NavigationBar;
use OrderListing\components\Pagination;
use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use yii\data\ActiveDataProvider;

$this->title = Yii::t('application', ApplicationTab::Orders->value);
?>
<?php
/** @var ActiveDataProvider $orderDataProvider */
/** @var ActiveDataProvider $serviceDataProvider */
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
                    [ServiceDropdown::widget(['serviceDataProvider' => $serviceDataProvider]), 'dropdown-th'],
                    [Yii::t('orders', OrdersColumn::Status->value)],
                    [ModeDropdown::widget(), 'dropdown-th'],
                    [Yii::t('orders', OrdersColumn::Created->value)]
                ]
            ]
        ) ?>
        <?= Body::widget(['orderDataProvider' => $orderDataProvider]) ?>
    </table>
    <?= Pagination::widget([
        'pagination' => $orderDataProvider->getPagination(),
        'totalAmount' => $orderDataProvider->totalCount
    ]) ?>
    <?= Export::widget() ?>
</div>

