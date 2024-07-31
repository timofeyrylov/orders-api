<?php

use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;

return [
    'orders.tab.all' => 'All orders',
    'orders.tab.pending' => 'Pending',
    'orders.tab.in_progress' => 'In progress',
    'orders.tab.completed' => 'Completed',
    'orders.tab.cancelled' => 'Cancelled',
    'orders.tab.error' => 'Error',
    OrdersColumn::ID->value => 'ID',
    OrdersColumn::User->value => 'User',
    OrdersColumn::Link->value => 'Link',
    OrdersColumn::Quantity->value => 'Quantity',
    OrdersColumn::Service->value => 'Service',
    OrdersColumn::Status->value => 'Status',
    OrdersColumn::Mode->value => 'Mode',
    OrdersColumn::Created->value => 'Created',
    'orders.search.placeholder' => 'Search orders'
];