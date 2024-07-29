<?php

namespace OrderListing\widgets;

use yii\base\Widget;
use yii\data\Pagination as DataPagination;

class Pagination extends Widget
{
    public DataPagination $pagination;

    public int $totalAmount;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('@OrderListing/views/order/pagination', ['pagination' => $this->pagination, 'totalAmount' => $this->totalAmount]);
    }
}