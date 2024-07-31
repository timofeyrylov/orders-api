<?php

namespace OrderListing\models\search;

use yii\base\Model;
use yii\data\Pagination;
use yii\db\ActiveQuery;

abstract class BaseSearch extends Model
{
    /**
     * Количество моделей на странице
     */
    const int MODELS_PER_PAGE = 100;

    /**
     * Поисковый запрос
     * @var ActiveQuery|null
     */
    protected ?ActiveQuery $query = null;

    /**
     * Пагинатор
     * @var Pagination|null
     */
    protected ?Pagination $paginator = null;

    /**
     * Создание поискового запроса
     * @return ActiveQuery
     */
    protected abstract function createQuery(): ActiveQuery;

    /**
     * Получение пагинатора
     * @return Pagination
     */
    public function getPaginator(): Pagination
    {
        return $this->paginator ??= $this->createPaginator();
    }

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

    /**
     * Создание пагинатора
     * @return Pagination
     */
    protected function createPaginator(): Pagination
    {
        return new Pagination([
            'pageSize' => self::MODELS_PER_PAGE,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
    }
}