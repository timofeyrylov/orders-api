<?php

use app\modules\OrderListing\Module;
use app\modules\OrderListing\thesaurus\ModeThesaurus;
use app\modules\OrderListing\thesaurus\SearchTypeThesaurus;
use app\modules\OrderListing\thesaurus\StatusThesaurus;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = Module::translate('listing', 'Orders');
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
                <?= Module::translate('listing', $status->getLabel()) ?>
            </a>
        </li>
        <?php endforeach; ?>
        <li class="pull-right custom-search">
            <form class="form-inline" action="<?= Url::current() ?>" method="get">
                <div class="input-group">
                    <input type="text" name="searchValue" class="form-control" value=" <?= Html::encode($_SESSION['SEARCH']['VALUE']) ?>" placeholder="<?= Module::translate('listing', 'Search orders') ?>">
                    <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="searchType">
              <?php foreach (SearchTypeThesaurus::cases() as $searchType): ?>
                  <option value="<?= $searchType->value ?>" <?php if ($_SESSION['SEARCH']['TYPE'] === $searchType->value): ?>selected=""<?php endif; ?>><?= Module::translate('listing', $searchType->getLabel()) ?></option>
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
            <th><?= Module::translate('listing', 'ID') ?></th>
            <th><?= Module::translate('listing', 'User') ?></th>
            <th><?= Module::translate('listing', 'Link') ?></th>
            <th><?= Module::translate('listing', 'Quantity') ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Module::translate('listing', 'Service') ?>
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
            <th><?= Module::translate('listing', 'Status') ?></th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= Module::translate('listing', 'Mode') ?>
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
            <th><?= Module::translate('listing', 'Created') ?></th>
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
                <td><?= Html::encode(StatusThesaurus::getStatusName($model->status)) ?></td>
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
            <?= Module::translate('listing', 'to') ?>
            <?= $orderDataProvider->getPagination()->getOffset() + $orderDataProvider->getPagination()->getLimit() ?>
            <?= Module::translate('listing', 'of') ?>
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
        ]) ?>"><?= Module::translate('listing', 'Save result') ?></a>
    </button>
</div>

