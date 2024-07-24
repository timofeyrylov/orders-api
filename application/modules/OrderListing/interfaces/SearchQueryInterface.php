<?php

namespace OrderListing\interfaces;

use yii\db\ActiveQueryInterface;

interface SearchQueryInterface extends ActiveQueryInterface
{
    /**
     * Фильтрация по id заказа
     * @param int|null $id - Id заказа
     * @return SearchQueryInterface
     */
    public function findById(?int $id = null): SearchQueryInterface;

    /**
     * Фильтрация по имени пользователя
     * @param string|null $userName - Имя пользователя
     * @return SearchQueryInterface
     */
    public function findByUserName(?string $userName = null): SearchQueryInterface;

    /**
     * Фмльтрация по ссылке
     * @param string|null $link - Ссылка
     * @return SearchQueryInterface
     */
    public function findByLink(?string $link): SearchQueryInterface;
}