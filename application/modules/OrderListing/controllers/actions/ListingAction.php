<?php

namespace OrderListing\controllers\actions;

use OrderListing\models\search\OrderSearch;
use OrderListing\models\search\ServiceSearch;
use Yii;
use yii\base\Action;
use yii\base\Exception;

class ListingAction extends Action
{
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
        return $this->controller->render('listing', [
            'orders' => $orderSearch->search(),
            'pagination' => $orderSearch->getPaginator(),
            'services' => $serviceSearch->search()
        ]);
    }
}