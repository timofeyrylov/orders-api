<?php

namespace OrderListing\components\grid;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class Body extends Widget
{
    public ActiveDataProvider $orderDataProvider;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/grid/body', ['orderDataProvider' => $this->orderDataProvider]);
    }
}