<?php

namespace OrderListing\widgets\grid;

use yii\base\Widget;

class ModeDropdown extends Widget
{
    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/grid/mode_dropdown');
    }
}