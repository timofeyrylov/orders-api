<?php

namespace OrderListing\models;

use OrderListing\thesaurus\ModeThesaurus;
use OrderListing\thesaurus\StatusThesaurus;
use yii\db\ActiveQuery;

class SearchOrder extends Search
{
    /**
     * @var int|null
     */
    public ?int $serviceId = null;

    /**
     * @return array<>
     */
    public function rules(): array
    {
        return [
            [['status', 'searchType', 'searchValue', 'mode', 'serviceId'] , 'safe']
        ];
    }

    /**
     * Поиск заказов
     * @return ActiveQuery
     */
    public function search(): ActiveQuery
    {
        return $this->build()->findByStatus(StatusThesaurus::getStatusId($this->status))
            ->findByMode(ModeThesaurus::getModeId($this->mode))
            ->findByService($this->serviceId)
            ->orderBy(['id' => SORT_DESC]);
    }
}