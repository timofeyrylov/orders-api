<?php

namespace OrderListing\components;

use yii\base\Widget;

class SearchBar extends Widget
{
    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/search');
    }
}