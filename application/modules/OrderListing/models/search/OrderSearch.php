<?php

namespace OrderListing\models\search;

use OrderListing\models\Order;
use OrderListing\models\query\OrderQuery;
use OrderListing\models\Service;
use OrderListing\thesaurus\ModeThesaurus;
use OrderListing\thesaurus\SearchTypeThesaurus;
use OrderListing\thesaurus\StatusThesaurus;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\BatchQueryResult;

class OrderSearch extends BaseSearch
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
     * Id сервиса
     * @var int|null
     */
    public $serviceId = null;

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
            ['mode', 'in', 'range' => array_map(fn(ModeThesaurus $mode): string => $mode->value, ModeThesaurus::cases())],
            ['serviceId', 'integer'],
            ['serviceId', 'default', 'value' => null],
            ['serviceId', 'exist', 'targetClass' => Service::class, 'targetAttribute' => ['serviceId' => 'id']]
        ];
    }

    /**
     * Фильтарция по номеру заказа
     * @param int|null $id - Id заказа
     * @return $this
     */
    public function applyFilterById(?int $id): self
    {
        $this->getQuery()->andFilterWhere(['orders.id' => $id]);
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
            $this->getQuery()
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
            $this->getQuery()->andFilterWhere(['like', 'upper(orders.link)', mb_strtoupper(trim($link))]);
        }
        return $this;
    }

    /**
     * Фильтрация по сервису
     * @param int|null $serviceId - Id сервиса
     * @return $this
     */
    public function applyFilterByService(?int $serviceId): self
    {
        $this->getQuery()->andFilterWhere(['service_id' => $serviceId]);
        return $this;
    }

    /**
     * Фильтрация по статусу заказа
     * @param int|null $status - Id статуса
     * @return $this
     */
    public function applyFilterByStatus(?int $status): self
    {
        $this->getQuery()->andFilterWhere(['status' => $status]);
        return $this;
    }

    /**
     * Фильтрация по режиму заказа
     * @param int|null $mode - Режим
     * @return $this
     */
    public function applyFilterByMode(?int $mode): self
    {
        $this->getQuery()->andFilterWhere(['mode' => $mode]);
        return $this;
    }

    /**
     * Получение результата поискового запроса
     * @return array<>
     */
    public function search(): array
    {
        return $this->getQuery()
            ->select(['orders.id', 'u.first_name', 'u.last_name', 'link', 'quantity', 's.name', 'status', 'created_at', 'mode'])
            ->joinWith('user u', false)
            ->joinWith('service s', false)
            ->orderBy(['id' => SORT_DESC])
            ->offset($this->getPaginator()->getOffset())
            ->limit($this->getPaginator()->getLimit())
            ->asArray()
            ->all();
    }

    /**
     * Пакетное получение результата поискового запроса
     * @return BatchQueryResult
     */
    public function batchSearch(): BatchQueryResult
    {
        return $this->getQuery()
            ->select(['orders.id', 'u.first_name', 'u.last_name', 'link', 'quantity', 's.name', 'status', 'created_at', 'mode'])
            ->joinWith('user u', false)
            ->joinWith('service s', false)
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->batch();
    }

    /**
     * Получение общего количества записей,
     * удовлетворяющих поисковому запросу
     * @return int
     */
    public function getTotalAmount(): int
    {
        $query = clone $this->getQuery();

        if (isset($this->searchType, $this->searchValue) && SearchTypeThesaurus::tryFrom($this->searchType) === SearchTypeThesaurus::UserName) {
            $query->joinWith('user u', false);
        }

        return $query->count();
    }

    /**
     * Сборка поискового запроса
     * @return OrderQuery
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

        $this->applyFilterByService($this->serviceId)
            ->applyFilterByStatus(StatusThesaurus::getStatusId($this->status))
            ->applyFilterByMode(ModeThesaurus::getModeId($this->mode));

        return $this->getQuery();
    }

    /**
     * Создание поискового запроса
     * @return OrderQuery
     */
    protected function createQuery(): ActiveQuery
    {
        return Order::find();
    }

    /**
     * Создание пагинатора
     * @return Pagination
     */
    protected function createPaginator(): Pagination
    {
        $paginator = parent::createPaginator();
        $paginator->totalCount = $this->getTotalAmount();
        return $paginator;
    }
}