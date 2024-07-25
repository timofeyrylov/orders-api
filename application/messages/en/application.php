<?php

use app\thesaurus\codes\ExportThesaurus as ApplicationExport;
use app\thesaurus\codes\PaginationThesaurus as ApplicationPagination;
use app\thesaurus\codes\TabThesaurus as ApplicationTab;

return [
    ApplicationTab::Orders->value => 'Orders',
    ApplicationPagination::To->value => 'to',
    ApplicationPagination::From->value => 'from',
    ApplicationExport::Save->value => 'Save result'
];