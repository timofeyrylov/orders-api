<?php

namespace OrderListing\thesaurus;

use OrderListing\interfaces\SearchQueryInterface;
use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;

enum SearchTypeThesaurus: string
{
    case OrderId = 'order_id';

    case Link = 'link';

    case UserName = 'user_name';

    /**
     * Получение имени типа поиска
     * @return string
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::OrderId => OrdersColumn::ID->value,
            self::Link => OrdersColumn::Link->value,
            self::UserName => OrdersColumn::User->value
        };
    }

    /**
     * Получение запроса на поиск
     * @param SearchQueryInterface $query - Исходный запрос
     * @param string $type - Тип поиска
     * @param int|string|null $searchValue - Поисковый запрос
     * @return SearchQueryInterface
     */
    public static function getQuery(SearchQueryInterface $query, string $type = '', int|string|null $searchValue = null): SearchQueryInterface
    {
        return match (self::tryFrom($type)) {
            self::OrderId => $query->findById($searchValue),
            self::Link => $query->findByLink($searchValue),
            self::UserName => $query->findByUserName($searchValue),
            default => $query
        };
    }
}