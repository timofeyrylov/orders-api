<?php

use OrderListing\models\Order;
use OrderListing\thesaurus\ModeThesaurus;
use OrderListing\thesaurus\StatusThesaurus;
use yii\helpers\Html;

/** @var array<Order> $orders */

?>

<tbody>
<?php foreach ($orders as $model): ?>
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