<?php

namespace OrderListing\widgets\grid;

use yii\base\Widget;

class Body extends Widget
{
    /**
     * @var array<array>
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