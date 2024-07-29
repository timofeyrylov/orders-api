<?php

namespace OrderListing\actions;

use OrderListing\models\Order;
use OrderListing\models\SearchOrder;
use OrderListing\models\SearchService;
use OrderListing\models\Service;
use Yii;
use yii\base\Action;
use yii\data\Pagination;

class ListingAction extends Action
{
    /**
     * Получение списка заказов и сервисов
     * @return string
     */
    public function run(): string
    {
        $searchOrder = (new SearchOrder())->setModel(new Order());
        $searchOrder->load(Yii::$app->request->get(), '');
        $searchService = (new SearchService())->setModel(new Service());
        $searchService->load(Yii::$app->request->get(), '');
        $ordersQuery = $searchOrder->search();
        $servicesQuery = $searchService->search();
        $pagination = new Pagination([
            'totalCount' => $ordersQuery->count(),
            'pageSize' => 100,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        return $this->controller->render('listing', [
            'orders' => $ordersQuery->offset($pagination->getOffset())->limit($pagination->getLimit())->all(),
            'pagination' => $pagination,
            'services' => $servicesQuery->all(),
            'servicesTotalCount' => $servicesQuery->sum('amount')
        ]);
    }
}