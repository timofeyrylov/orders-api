<?php

use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use OrderListing\thesaurus\codes\SearchThesaurus as OrdersSearch;
use OrderListing\thesaurus\codes\TabThesaurus as OrdersTab;

return [
    OrdersTab::AllOrders->value => 'All orders',
    OrdersTab::Pending->value => 'Pending',
    OrdersTab::InProgress->value => 'In progress',
    OrdersTab::Completed->value => 'Completed',
    OrdersTab::Cancelled->value => 'Cancelled',
    OrdersTab::Error->value => 'Error',
    OrdersColumn::ID->value => 'ID',
    OrdersColumn::User->value => 'User',
    OrdersColumn::Link->value => 'Link',
    OrdersColumn::Quantity->value => 'Quantity',
    OrdersColumn::Service->value => 'Service',
    OrdersColumn::Status->value => 'Status',
    OrdersColumn::Mode->value => 'Mode',
    OrdersColumn::Created->value => 'Created',
    OrdersSearch::Placeholder->value => 'Search orders'
];