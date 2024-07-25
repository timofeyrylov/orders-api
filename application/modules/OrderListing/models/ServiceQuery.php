<?php

namespace OrderListing\models;

use OrderListing\interfaces\SearchQueryInterface;
use yii\db\ActiveQuery;

class ServiceQuery extends ActiveQuery implements SearchQueryInterface
{
    /**
     * Фильтрация по статусу заказа
     * @param int|null $statusId - Id статуса
     * @return ServiceQuery
     */
    public function findByStatus(?int $statusId = null): ServiceQuery
    {
        return $this->joinWith('orders', false)->andFilterWhere(['orders.status' => $statusId]);
    }

    /**
     * Фильтрация по режиму заказа
     * @param int|null $mode - Id мода
     * @return ServiceQuery
     */
    public function findByMode(?int $mode = null): ServiceQuery
    {
        return $this->joinWith('orders', false)->andFilterWhere(['orders.mode' => $mode]);
    }

    /**
     * Фильтрация по id заказа
     * @param int|null $id - Id заказа
     * @return SearchQueryInterface
     */
    public function findById(?int $id = null): SearchQueryInterface
    {
        return $this->joinWith('orders', false)->andFilterWhere(['orders.id' => $id]);
    }

    /**
     * Фильтрация по имени пользователя
     * @param string|null $userName - Имя пользователя
     * @return SearchQueryInterface
     */
    public function findByUserName(?string $userName = null): SearchQueryInterface
    {
        return $this->joinWith('orders', false)
            ->leftJoin('users', 'users.id = orders.user_id')
            ->andFilterWhere(['like', 'upper(concat(users.first_name, " ", users.last_name))', mb_strtoupper(trim($userName))]);
    }

    /**
     * Фмльтрация по ссылке
     * @param string|null $link - Ссылка
     * @return SearchQueryInterface
     */
    public function findByLink(?string $link): SearchQueryInterface
    {
        return $this->joinWith('orders', false)->andFilterWhere(['like', 'upper(orders.link)', mb_strtoupper(trim($link))]);
    }

    /**
     * Получение количества заказов по сервисам
     * @return ServiceQuery
     */
    public function getAmount(): ServiceQuery
    {
        return $this->select('services.id, services.name, count(services.id) as amount')
            ->groupBy('services.id');
    }

    /**
     * Получения списка сервисов с количеством заказов по ним
     * @param ServiceQuery $subQuery
     * @return ServiceQuery
     */
    public function getListing(ServiceQuery $subQuery): ServiceQuery
    {
        return $this->select(['services.id', 'services.name', 'coalesce(sub.amount, 0) as amount'])
            ->leftJoin(['sub' => $subQuery], 'sub.id=services.id')
            ->orderBy(['amount' => SORT_DESC]);
    }
}