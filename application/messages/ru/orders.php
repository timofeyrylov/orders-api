<?php

use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;

return [
    'orders.tab.all' => 'Все заказы',
    'orders.tab.pending' => 'В ожидании',
    'orders.tab.in_progress' => 'В обработке',
    'orders.tab.completed' => 'Завершены',
    'orders.tab.cancelled' => 'Отменены',
    'orders.tab.error' => 'С ошибкой',
    OrdersColumn::ID->value => 'Идентификатор',
    OrdersColumn::User->value => 'Пользователь',
    OrdersColumn::Link->value => 'Ссылка',
    OrdersColumn::Quantity->value => 'Количество',
    OrdersColumn::Service->value => 'Сервис',
    OrdersColumn::Status->value => 'Статус',
    OrdersColumn::Mode->value => 'Режим',
    OrdersColumn::Created->value => 'Дата создания',
    'orders.search.placeholder' => 'Искать заказы'
];