<?php

namespace OrderListing\controllers;

use OrderListing\models\Order;
use OrderListing\models\Service;
use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use OrderListing\thesaurus\ModeThesaurus;
use OrderListing\thesaurus\SearchTypeThesaurus;
use OrderListing\thesaurus\StatusThesaurus;
use Yii;
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
        $orderQuery = SearchTypeThesaurus::getQuery(Order::find(), $searchType, $searchValue)->findByStatus(StatusThesaurus::getStatusId($status))
            ->findByMode(ModeThesaurus::getModeId($mode))
            ->findByService($serviceId)
            ->orderBy(['id' => SORT_DESC]);
        ob_start();
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="orders_' . date('d.m.Y') . '.csv"');
        $output = fopen('php://output', 'w');
        $columns = array_map(fn(OrdersColumn $column): string => Yii::t('orders', $column->value), OrdersColumn::cases());
        fputcsv($output, $columns);
        foreach ($orderQuery->each() as $model) {
            fputcsv($output, $model->toArray());
        }
        fclose($output);
        ob_end_flush();
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