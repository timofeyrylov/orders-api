<?php

namespace OrderListing\components\grid;

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