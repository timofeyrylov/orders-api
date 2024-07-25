<?php

use OrderListing\thesaurus\SearchTypeThesaurus;
use yii\helpers\Html;
use yii\helpers\Url;
use OrderListing\thesaurus\codes\SearchThesaurus as OrdersSearch;

?>
<li class="pull-right custom-search">
    <form class="form-inline" action="<?= Url::current() ?>" method="get">
        <div class="input-group">
            <input type="text" name="searchValue" class="form-control" value="<?= Html::encode(Yii::$app->request->get('searchValue')) ?>" placeholder="<?= Yii::t('orders', OrdersSearch::Placeholder->value) ?>">
            <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="searchType">
              <?php foreach (SearchTypeThesaurus::cases() as $searchType): ?>
                  <option value="<?= $searchType->value ?>" <?php if (Yii::$app->request->get('searchType') === $searchType->value): ?>selected=""<?php endif; ?>><?= Yii::t('orders', $searchType->getLabel()) ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
    </form>
</li>