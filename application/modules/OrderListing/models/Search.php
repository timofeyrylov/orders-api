<?php

namespace OrderListing\models;

use OrderListing\thesaurus\SearchTypeThesaurus;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Search extends Model
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
     * Модель, по которой идет поиск
     * @var ActiveRecord|null
     */
    protected ?ActiveRecord $model = null;

    /**
     * @return array<>
     */
    public function rules(): array
    {
        return [
            [['status', 'searchType', 'searchValue', 'mode'] , 'safe']
        ];
    }

    /**
     * Получение модели, по которой идет поиск
     * @return ActiveRecord
     */
    public function getModel(): ActiveRecord
    {
        return $this->model;
    }

    /**
     * Определение модели, по которой идет поиск
     * @param ActiveRecord $model
     * @return $this
     */
    public function setModel(ActiveRecord $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Получение запроса на поиск
     * @return ActiveQuery
     */
    protected function build(): ActiveQuery
    {
        $query = $this->getModel()::find();
        return match (SearchTypeThesaurus::tryFrom($this->searchType)) {
            SearchTypeThesaurus::OrderId => $query->findById($this->searchValue),
            SearchTypeThesaurus::Link => $query->findByLink($this->searchValue),
            SearchTypeThesaurus::UserName => $query->findByUserName($this->searchValue),
            default => $query
        };
    }
}