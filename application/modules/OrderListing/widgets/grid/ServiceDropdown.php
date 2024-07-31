<?php

namespace OrderListing\widgets\grid;

use yii\base\Widget;

class ServiceDropdown extends Widget
{
    /**
     * @var array<array>
     */
    public array $services;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/grid/service_dropdown', ['services' => $this->services]);
    }
}