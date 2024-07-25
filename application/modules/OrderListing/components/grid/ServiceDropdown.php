<?php

namespace OrderListing\components\grid;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class ServiceDropdown extends Widget
{
    public ActiveDataProvider $serviceDataProvider;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/grid/service_dropdown', ['serviceDataProvider' => $this->serviceDataProvider]);
    }
}