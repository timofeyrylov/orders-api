<?php

use app\thesaurus\codes\ExportThesaurus as ApplicationExport;
use app\thesaurus\codes\PaginationThesaurus as ApplicationPagination;
use app\thesaurus\codes\TabThesaurus as ApplicationTab;
use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use OrderListing\thesaurus\ModeThesaurus;
use OrderListing\thesaurus\SearchTypeThesaurus;
use OrderListing\thesaurus\StatusThesaurus;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = Yii::t('application', ApplicationTab::Orders->value);
?>
<?php
/** @var ActiveDataProvider $orderDataProvider */
/** @var ActiveDataProvider $serviceDataProvider */
?>
<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li><?php foreach (StatusThesaurus::cases() as $status): ?></li>
        <li <?php if ($_SESSION['SELECTED_FILTERS']['STATUS'] === $status->value): ?>class="active"<?php endif; ?>>
            <a href="<?= Url::toRoute(["/" . Yii::$app->language . "/orders/$status->value"]) ?>">
                <?= Yii::t('orders', $status->getLabel()) ?>
            </a>
        </li>
        <?php endforeach; ?>
        <li class="pull-right custom-search">
            <form class="form-inline" action="<?= Url::current() ?>" method="get">
                <div class="input-group">
                    <input type="text" name="searchValue" class="form-control" value=" <?= Html::encode($_SESSION['SEARCH']['VALUE']) ?>" placeholder="<?= Yii::t('listing', 'Search orders') ?>">
                    <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="searchType">
              <?php foreach (SearchTypeThesaurus::cases() as $searchType): ?>
                  <option value="<?= $searchType->value ?>" <?php if ($_SESSION['SEARCH']['TYPE'] === $searchType->value): ?>selected=""<?php endif; ?>><?= Yii::t('orders', $searchType->getLabel()) ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
                </div>
            </form>
        </li>
    </ul>
    <table class="table order-table">
        <thead>
        <tr>
            <th><?= Yii::t('orders', OrdersColumn::ID->value) ?></th>
            <th><?= Yii::t('orders', OrdersColumn::User->value) ?></th>
            <th><?= Yii::t('orders', OrdersColumn::Link->value) ?></th>
            <th><?= Yii::t('orders', OrdersColumn::Quantity->value) ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Yii::t('orders', OrdersColumn::Service->value) ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                            <a href="<?= Url::current(['serviceId' => null]) ?>">
                                All (<?= $serviceDataProvider->totalCount ?>)
                            </a>
                        </li>
                        <?php foreach ($serviceDataProvider->getModels() as $model): ?>
                            <li
                                <?php if ($_SESSION['SELECTED_FILTERS']['SERVICE'] === $model->id): ?>
                                    class="active"
                                <?php elseif (!$model->amount): ?>
                                    class="disabled" aria-disabled="true"
                                <?php endif; ?>>
                                <a href="<?= Url::current(['serviceId' => $model->id]) ?>">
                                    <span class="label-id"><?= $model->amount ?></span> <?= $model->name ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </th>
            <th><?= Yii::t('orders', OrdersColumn::Status->value) ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Yii::t('orders', OrdersColumn::Mode->value) ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <?php foreach (ModeThesaurus::cases() as $mode): ?>
                            <li <?php if ($_SESSION['SELECTED_FILTERS']['MODE'] === $mode->value): ?>class="active"<?php endif; ?>>
                                <a href="<?= Url::current(['mode' => $mode->value]) ?>">
                                    <?= $mode->name ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </th>
            <th><?= Yii::t('orders', OrdersColumn::Created->value) ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orderDataProvider->getModels() as $model): ?>
            <tr>
                <td><?= $model->id ?></td>
                <td><?= Html::encode($model->userName) ?></td>
                <td class="link"><?= Html::encode($model->link) ?></td>
                <td><?= $model->quantity ?></td>
                <td><?= Html::encode($model->serviceName) ?></td>
                <td><?= Html::encode(Yii::t('orders', StatusThesaurus::getStatusName($model->status))) ?></td>
                <td><?= Html::encode(ModeThesaurus::getModeName($model->mode)) ?></td>
                <?php [$createDate, $createTime] = explode(' ', date('Y-m-d H:i:s', $model->created_at)) ?>
                <td><span class="nowrap"><?= $createDate ?></span><span class="nowrap"><?= $createTime ?></span></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-8">
            <?= LinkPager::widget(['pagination' => $orderDataProvider->getPagination()])?>
        </div>
        <div class="col-sm-4 pagination-counters">
            <?= $orderDataProvider->getPagination()->getOffset() + 1 ?>
            <?= Yii::t('application', ApplicationPagination::To->value) ?>
            <?= $orderDataProvider->getPagination()->getOffset() + $orderDataProvider->getPagination()->getLimit() ?>
            <?= Yii::t('application', ApplicationPagination::From->value) ?>
            <?= $orderDataProvider->totalCount ?>
        </div>
    </div>
    <button class="btn btn-th btn-default" type="button">
        <a href="<?= Url::toRoute([
            "/" . Yii::$app->language . "/orders/export/" . $_SESSION['SELECTED_FILTERS']['STATUS'],
            'serviceId' => $_SESSION['SELECTED_FILTERS']['SERVICE'],
            'searchType' => $_SESSION['SEARCH']['TYPE'],
            'searchValue' => $_SESSION['SEARCH']['VALUE'],
            'mode' => $_SESSION['SELECTED_FILTERS']['MODE']
        ]) ?>"><?= Yii::t('application', ApplicationExport::Save->value) ?></a>
    </button>
</div>

