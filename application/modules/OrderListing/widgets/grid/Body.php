<?php

namespace OrderListing\widgets\grid;

use OrderListing\models\Order;
use yii\base\Widget;

class Body extends Widget
{
    /**
     * @var array<Order>
     */
    public array $orders;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/grid/body', ['orders' => $this->orders]);
    }
}