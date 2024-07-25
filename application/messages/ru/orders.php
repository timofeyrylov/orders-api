<?php

use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use OrderListing\thesaurus\codes\TabThesaurus as OrdersTab;

return [
    OrdersTab::AllOrders->value => 'Все заказы',
    OrdersTab::Pending->value => 'В ожидании',
    OrdersTab::InProgress->value => 'В обработке',
    OrdersTab::Completed->value => 'Завершены',
    OrdersTab::Cancelled->value => 'Отменены',
    OrdersTab::Error->value => 'С ошибкой',
    OrdersColumn::ID->value => 'Идентификатор',
    OrdersColumn::User->value => 'Пользователь',
    OrdersColumn::Link->value => 'Ссылка',
    OrdersColumn::Quantity->value => 'Количество',
    OrdersColumn::Service->value => 'Сервис',
    OrdersColumn::Status->value => 'Статус',
    OrdersColumn::Mode->value => 'Режим',
    OrdersColumn::Created->value => 'Дата создания',
];