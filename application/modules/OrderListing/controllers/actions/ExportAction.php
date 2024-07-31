<?php

namespace OrderListing\controllers\actions;

use OrderListing\models\forms\ExportForm;
use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\web\RangeNotSatisfiableHttpException;

class ExportAction extends Action
{
    /**
     * Экспорт списка заказов и сервисов
     * @return void
     * @throws RangeNotSatisfiableHttpException|Exception
     */
    public function run(): void
    {
        $exportForm = new ExportForm();
        if (!$exportForm->load(Yii::$app->getRequest()->get(), '') || !$exportForm->validate()) {
            throw new Exception('Invalid parameters: ' . implode(' ', $exportForm->getErrorSummary(true)));
        }
        Yii::$app->getResponse()->sendContentAsFile($exportForm->export(), 'orders_' . date('d.m.Y') . '.csv', ['mimeType' => 'text/csv']);
    }
}