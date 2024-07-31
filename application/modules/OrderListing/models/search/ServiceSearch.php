<?php

namespace OrderListing\models\search;

use OrderListing\models\query\OrderQuery;
use OrderListing\models\query\ServiceQuery;
use OrderListing\models\Service;
use OrderListing\thesaurus\ModeThesaurus;
use OrderListing\thesaurus\SearchTypeThesaurus;
use OrderListing\thesaurus\StatusThesaurus;
use yii\db\ActiveQuery;

class ServiceSearch extends BaseSearch
{
    /**
     * Статус заказа
     * @var string|null
     */
    public ?string $status = '';

    /**
     * Тип поиска
     * @var string
     */
    public string $searchType = '';

    /**
     * Поисковый запрос
     * @var int|string|null
     */
    public int|string|null $searchValue = null;

    /**
     * Режим заказа
     * @var string
     */
    public string $mode = '';

    /**
     * @return array<>
     */
    public function rules(): array
    {
        return [
            ['status', 'in', 'range' => array_map(fn(StatusThesaurus $status): string => $status->value, StatusThesaurus::cases())],
            ['searchType', 'in', 'range' => array_map(fn(SearchTypeThesaurus $searchType): string => $searchType->value, SearchTypeThesaurus::cases())],
            ['searchValue', 'integer', 'when' => fn(): bool => $this->searchType === SearchTypeThesaurus::OrderId->value],
            ['searchValue', 'string', 'when' => fn(): bool => $this->searchType === SearchTypeThesaurus::Link->value],
            ['searchValue', 'string', 'when' => fn(): bool => $this->searchType === SearchTypeThesaurus::UserName->value],
            ['searchValue', 'default', 'value' => null],
            ['mode', 'in', 'range' => array_map(fn(ModeThesaurus $mode): string => $mode->value, ModeThesaurus::cases())]
        ];
    }

    /**
     * Фильтарция по номеру заказа
     * @param int|null $id - Id заказа
     * @return $this
     */
    public function applyFilterById(?int $id): self
    {
        $this->joinWith('orders', 'o')->getQuery()
            ->andFilterWhere(['o.id' => $id]);
        return $this;
    }

    /**
     * Фильтрация по имени пользователя
     * @param string|null $userName - Имя пользователя
     * @return $this
     */
    public function applyFilterByUserName(?string $userName): self
    {
        if (isset($userName)) {
            $this->joinWith('orders', 'o', fn(OrderQuery $query) => $query->joinWith('user u'))
                ->getQuery()
                ->andFilterWhere(['like', 'upper(concat(u.first_name, " ", u.last_name))', mb_strtoupper(trim($userName))]);
        }
        return $this;
    }

    /**
     * Фильтрация по ссылке в заказе
     * @param string|null $link - Ссылка
     * @return $this
     */
    public function applyFilterByLink(?string $link): self
    {
        if (isset($link)) {
            $this->joinWith('orders', 'o')->getQuery()
                ->andFilterWhere(['like', 'upper(o.link)', mb_strtoupper(trim($link))]);
        }
        return $this;
    }

    /**
     * Фильтрация по статусу заказа
     * @param int|null $status - Id статуса
     * @return $this
     */
    public function applyFilterByStatus(?int $status): self
    {
        $this->joinWith('orders', 'o')->getQuery()
            ->andFilterWhere(['o.status' => $status]);
        return $this;
    }

    /**
     * Фильтрация по режиму заказа
     * @param int|null $mode - Режим
     * @return $this
     */
    public function applyFilterByMode(?int $mode): self
    {
        $this->joinWith('orders', 'o')->getQuery()
            ->andFilterWhere(['o.mode' => $mode]);
        return $this;
    }

    /**
     * Получение результата поискового запроса
     * @return array
     */
    public function search(): array
    {
        $this->getQuery()->select(['services.id', 'count(services.id) as amount'])
            ->groupBy('services.id');

        return parent::buildQuery()->select(['services.id', 'services.name', 'coalesce(sub.amount, 0) as amount'])
            ->leftJoin(['sub' => $this->getQuery()], 'sub.id = services.id')
            ->orderBy(['amount' => SORT_DESC])
            ->asArray()
            ->all();
    }

    /**
     * Сборка поискового запроса
     * @return ServiceQuery
     */
    public function buildQuery(): ActiveQuery
    {
        $this->query = parent::buildQuery();
        match (SearchTypeThesaurus::tryFrom($this->searchType)) {
            SearchTypeThesaurus::OrderId => $this->applyFilterById($this->searchValue),
            SearchTypeThesaurus::UserName => $this->applyFilterByUserName($this->searchValue),
            SearchTypeThesaurus::Link => $this->applyFilterByLink($this->searchValue),
            default => null
        };

        $this->applyFilterByStatus(StatusThesaurus::getStatusId($this->status))
            ->applyFilterByMode(ModeThesaurus::getModeId($this->mode));

        return $this->getQuery();
    }

    /**
     * Создание поискового запроса
     * @return ServiceQuery
     */
    protected function createQuery(): ActiveQuery
    {
        return Service::find();
    }
}