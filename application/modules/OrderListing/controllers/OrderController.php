<?php

namespace app\modules\OrderListing\controllers;

use app\modules\OrderListing\models\Order;
use app\modules\OrderListing\models\Service;
use app\modules\OrderListing\Module;
use app\modules\OrderListing\thesaurus\ColumnThesaurus;
use app\modules\OrderListing\thesaurus\ModeThesaurus;
use app\modules\OrderListing\thesaurus\SearchTypeThesaurus;
use app\modules\OrderListing\thesaurus\StatusThesaurus;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class OrderController extends Controller
{
    /**
     * Получение списка заказов и сервисов
     * @param string|null $status - Статус заказа
     * @param string $searchType - Тип поиска
     * @param int|string|null $searchValue - Поисковый запрос
     * @param string $mode - Режим заказа
     * @param int|null $serviceId - Id сервиса
     * @return string
     * @throws InvalidConfigException
     */
    public function actionGet(?string $status = '', string $searchType = '', int|string|null $searchValue = null, string $mode = '', ?int $serviceId = null): string
    {
        $this->setSession($status, $searchType, $searchValue, $mode, $serviceId);
        $orderDataProvider = $this->getOrders($status, $searchType, $searchValue, $mode, $serviceId);
        $serviceDataProvider = $this->getServices($status, $searchType, $searchValue, $mode);
        return $this->render('listing', [
            'orderDataProvider' => $orderDataProvider,
            'serviceDataProvider' => $serviceDataProvider
        ]);
    }

    /**
     * Экспорт спсика заказов и сервисов
     * @param string|null $status - Статус заказа
     * @param string $searchType - Тип поиска
     * @param int|string|null $searchValue - Поисковый запрос
     * @param string $mode - Режим заказа
     * @param int|null $serviceId - Id сервиса
     * @return void
     * @throws InvalidConfigException
     */
    public function actionExport(?string $status = '', string $searchType = '', int|string|null $searchValue = null, string $mode = '', ?int $serviceId = null)
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="orders_' . date('d.m.Y') . '.csv"');
        $orderQuery = SearchTypeThesaurus::getQuery(Order::find(), $searchType, $searchValue)->findByStatus(StatusThesaurus::getStatusId($status))
            ->findByMode(ModeThesaurus::getModeId($mode))
            ->findByService($serviceId)
            ->orderBy(['id' => SORT_DESC]);
        foreach (ColumnThesaurus::cases() as $column) {
            echo Module::translate('listing', $column->name) . ';';
        }
        echo "\r\n";
        foreach ($orderQuery->each() as $model) {
            echo $model->id . ';'.
                $model->userName . ';' .
                $model->link . ';' .
                $model->quantity . ';' .
                $model->serviceName . ';' .
                StatusThesaurus::getStatusName($model->status) . ';' .
                ModeThesaurus::getModeName($model->mode) . ';' .
                date('Y-m-d H:i:s', $model->created_at) . ";\r\n";
        }
        die();
    }

    /**
     * Инициализация пользовательской сессии
     * @param string|null $status - Статус заказа
     * @param string $searchType - Тип поиска
     * @param int|string|null $searchValue - Поисковый запрос
     * @param string $mode - Режим заказа
     * @param int|null $serviceId - Id сервиса
     * @return void
     */
    private function setSession(?string $status = '', string $searchType = '', int|string|null $searchValue = null, string $mode = '', ?int $serviceId = null): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['SELECTED_FILTERS']['STATUS'] = $status;
        $_SESSION['SELECTED_FILTERS']['MODE'] = $mode;
        $_SESSION['SELECTED_FILTERS']['SERVICE'] = $serviceId;
        $_SESSION['SEARCH']['TYPE'] = $searchType;
        $_SESSION['SEARCH']['VALUE'] = $searchValue;
        session_write_close();
    }

    /**
     * Получение списка заказов
     * @param string|null $status - Статус заказа
     * @param string $searchType - Тип поиска
     * @param int|string|null $searchValue - Поисковый запрос
     * @param string $mode - Режим заказа
     * @param int|null $serviceId - Id сервиса
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    private function getOrders(?string $status = '', string $searchType = '', int|string|null $searchValue = null, string $mode = '', ?int $serviceId = null): ActiveDataProvider
    {
        $orderQuery = SearchTypeThesaurus::getQuery(Order::find(), $searchType, $searchValue)->findByStatus(StatusThesaurus::getStatusId($status))
            ->findByMode(ModeThesaurus::getModeId($mode))
            ->findByService($serviceId);
        return new ActiveDataProvider([
            'query' => $orderQuery,
            'totalCount' => $orderQuery->count(),
            'pagination' => [
                'pageSize' => 100,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
    }

    /**
     * Получение списка сервисов
     * @param string|null $status - Статус заказа
     * @param string $searchType - Тип поиска
     * @param int|string|null $searchValue - Поисковый запрос
     * @param string $mode - Режим заказа
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    private function getServices(?string $status = '', string $searchType = '', int|string|null $searchValue = null, string $mode = ''): ActiveDataProvider
    {
        $serviceSubQuery = SearchTypeThesaurus::getQuery(Service::find(), $searchType, $searchValue)->findByStatus(StatusThesaurus::getStatusId($status))
            ->findByMode(ModeThesaurus::getModeId($mode))
            ->getAmount();
        $serviceQuery = Service::find()->getListing($serviceSubQuery);
        return new ActiveDataProvider([
            'query' => $serviceQuery,
            'totalCount' => $serviceQuery->sum('amount'),
        ]);
    }
}