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

    /**
     * Джойн с учетом уникальности
     * @param string $model - Имя присоединяемой модели
     * @param string $alias - Алиас
     * @param bool $eagerLoading - Нужна ли активная загрузка
     * @return $this
     */
    protected function joinWith(string $model, string $alias, ?callable $function = null, bool $eagerLoading = false): self
    {
        $isAlreadyJoined = false;
        if ($this->getQuery()->joinWith) {
            foreach ($this->getQuery()->joinWith as $join) {
                if (isset($join[0][$model])) {
                    $isAlreadyJoined = true;
                }
            }
        }
        if ($this->getQuery()->join) {
            foreach ($this->getQuery()->join as $join) {
                if (isset($join[1][$alias])) {
                    $isAlreadyJoined = true;
                }
            }
        }
        $isAlreadyJoined ?: $this->getQuery()->joinWith([$model . ' ' . $alias => $function], $eagerLoading);
        return $this;
    }
}