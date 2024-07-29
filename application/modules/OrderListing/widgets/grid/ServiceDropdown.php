<?php

namespace OrderListing\widgets\grid;

use OrderListing\models\Service;
use yii\base\Widget;

class ServiceDropdown extends Widget
{
    /**
     * @var array<Service>
     */
    public array $services;

    /**
     * @var int
     */
    public int $totalCount;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/grid/service_dropdown', ['services' => $this->services, 'totalCount' => $this->totalCount]);
    }
}