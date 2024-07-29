<?php

use OrderListing\thesaurus\StatusThesaurus;
use OrderListing\widgets\SearchBar;
use yii\helpers\Url;

?>
<ul class="nav nav-tabs p-b">
    <li><?php foreach (StatusThesaurus::cases() as $status): ?></li>
    <li <?php if (Yii::$app->request->get('status') === $status->value): ?>class="active"<?php endif; ?>>
        <a href="<?= Url::toRoute(["/$status->value"]) ?>">
            <?= Yii::t('orders', $status->getLabel()) ?>
        </a>
    </li>
    <?php endforeach; ?>
    <?= SearchBar::widget() ?>
</ul>