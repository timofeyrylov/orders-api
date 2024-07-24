<?php

namespace OrderListing\models;

use OrderListing\interfaces\SearchQueryInterface;
use yii\db\ActiveQuery;
use yii\db\Query;

class OrderQuery extends ActiveQuery implements SearchQueryInterface
{
    /**
     * Фильтрация по статусу
     * @param int|null $statusId - Id статуса
     * @return OrderQuery
     */
    public function findByStatus(?int $statusId = null): Query
    {
        return $this->andFilterWhere(['status' => $statusId]);
    }

    /**
     * Фильтрация по режиму
     * @param int|null $mode - Id мода
     * @return OrderQuery
     */
    public function findByMode(?int $mode = null): Query
    {
        return $this->andFilterWhere(['mode' => $mode]);
    }

    /**
     * Фильтрация по сервису
     * @param int|null $serviceId - Id сервиса
     * @return OrderQuery
     */
    public function findByService(?int $serviceId = null): Query
    {
        return $this->andFilterWhere(['service_id' => $serviceId]);
    }

    /**
     * Фильтрация по id заказа
     * @param int|null $id - Id заказа
     * @return OrderQuery
     */
    public function findById(?int $id = null): OrderQuery
    {
        return $this->andFilterWhere(['id' => $id]);
    }

    /**
     * Фильтрация по имени пользователя
     * @param string|null $userName - Имя пользователя
     * @return OrderQuery
     */
    public function findByUserName(?string $userName = null): OrderQuery
    {
        return $this->andFilterWhere(['like', 'upper(concat(u.first_name, "", u.last_name))', mb_strtoupper(trim($userName))]);
    }

    /**
     * Фмльтрация по ссылке
     * @param string|null $link - Ссылка
     * @return OrderQuery
     */
    public function findByLink(?string $link): OrderQuery
    {
        return $this->andFilterWhere(['like', 'upper(orders.link)', mb_strtoupper(trim($link))]);
    }
}