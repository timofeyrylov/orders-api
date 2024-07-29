<?php

namespace OrderListing\thesaurus;

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
}