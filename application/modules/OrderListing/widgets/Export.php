<?php

namespace OrderListing\widgets;

use yii\base\Widget;

class Export extends Widget
{
    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/export');
    }
}