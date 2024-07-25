<?php

namespace OrderListing\components\grid;

use yii\base\Widget;

class Header extends Widget
{
    public array $columns = [];

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/grid/header', ['columns' => $this->columns]);
    }
}