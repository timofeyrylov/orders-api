<?php

use app\thesaurus\codes\ExportThesaurus as ApplicationExport;
use app\thesaurus\codes\PaginationThesaurus as ApplicationPagination;
use app\thesaurus\codes\TabThesaurus as ApplicationTab;

return [
    ApplicationTab::Orders->value => 'Заказы',
    ApplicationPagination::To->value => '...',
    ApplicationPagination::From->value => 'из',
    ApplicationExport::Save->value => 'Скачать результат'
];