<?php

namespace OrderListing\thesaurus\codes;

enum ColumnThesaurus: string
{
    case ID = 'orders.column.id';

    case User = 'orders.column.user';

    case Link = 'orders.column.link';

    case Quantity = 'orders.column.quantity';

    case Service = 'orders.column.service';

    case Status = 'orders.column.status';

    case Mode = 'orders.column.mode';

    case Created = 'orders.column.created';
}