<?php

namespace OrderListing\models\query;

use OrderListing\models\Order;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Order]].
 *
 * @see Order
 */
class OrderQuery extends ActiveQuery
{
    /**
     * @return array<Order>
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @return array<Order>|null
     */
    public function one($db = null): ?array
    {
        return parent::one($db);
    }
}
