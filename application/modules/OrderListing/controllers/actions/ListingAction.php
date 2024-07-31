<?php

namespace OrderListing\controllers\actions;

use OrderListing\models\search\OrderSearch;
use OrderListing\models\search\ServiceSearch;
use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\data\Pagination;

class ListingAction extends Action
{
    const int ORDERS_PER_PAGE = 100;

    /**
     * Получение списка заказов и сервисов
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        $orderSearch = new OrderSearch();
        if (!$orderSearch->load(Yii::$app->getRequest()->get(), '') || !$orderSearch->validate()) {
            throw new Exception('Invalid parameters: ' . implode(' ', $orderSearch->getErrorSummary(true)));
        }
        $serviceSearch = new ServiceSearch();
        if (!$serviceSearch->load(Yii::$app->getRequest()->get(), '') || !$serviceSearch->validate()) {
            throw new Exception('Invalid parameters: ' . implode(' ', $serviceSearch->getErrorSummary(true)));
        }
        $pagination = new Pagination([
            'totalCount' => $orderSearch->getTotalAmount(),
            'pageSize' => self::ORDERS_PER_PAGE,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        return $this->controller->render('listing', [
            'orders' => $orderSearch->search($pagination),
            'pagination' => $pagination,
            'services' => $serviceSearch->search()
        ]);
    }
}