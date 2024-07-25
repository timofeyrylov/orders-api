<?php

namespace OrderListing\thesaurus\codes;

enum TabThesaurus: string
{
    case AllOrders = 'orders.tab.all';

    case Pending = 'orders.tab.pending';

    case InProgress = 'orders.tab.in_progress';

    case Completed = 'orders.tab.completed';

    case Cancelled = 'orders.tab.cancelled';

    case Error = 'orders.tab.error';
}