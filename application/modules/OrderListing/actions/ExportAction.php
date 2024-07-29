<?php

namespace OrderListing\actions;

use OrderListing\forms\ExportForm;
use yii\base\Action;
use yii\web\RangeNotSatisfiableHttpException;

class ExportAction extends Action
{
    /**
     * Экспорт списка заказов и сервисов
     * @return void
     * @throws RangeNotSatisfiableHttpException
     */
    public function run(): void
    {
        (new ExportForm())->export();
    }
}