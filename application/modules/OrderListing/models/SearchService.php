<?php

namespace OrderListing\models;

use OrderListing\thesaurus\ModeThesaurus;
use OrderListing\thesaurus\StatusThesaurus;
use yii\db\ActiveQuery;

class SearchService extends Search
{
    /**
     * Поиск сервисов
     * @return ActiveQuery
     */
    public function search(): ActiveQuery
    {
        $query = $this->build()->findByStatus(StatusThesaurus::getStatusId($this->status))
            ->findByMode(ModeThesaurus::getModeId($this->mode))
            ->getAmount();
        return $this->getModel()::find()->getListing($query);
    }
}