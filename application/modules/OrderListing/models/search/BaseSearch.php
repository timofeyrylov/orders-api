<?php

namespace OrderListing\models\search;

use yii\base\Model;
use yii\db\ActiveQuery;

abstract class BaseSearch extends Model
{
    /**
     * Поисковый запрос
     * @var ActiveQuery|null
     */
    protected ?ActiveQuery $query = null;

    /**
     * Создание поискового запроса
     * @return ActiveQuery
     */
    protected abstract function createQuery(): ActiveQuery;

    /**
     * Сборка поискового запроса
     * @return ActiveQuery
     */
    protected function buildQuery(): ActiveQuery
    {
        return $this->createQuery();
    }

    /**
     * Получение поискового запроса
     * @return ActiveQuery
     */
    protected function getQuery(): ActiveQuery
    {
        return $this->query ??= $this->buildQuery();
    }
}