<?php

namespace OrderListing\forms;

use OrderListing\models\Order;
use OrderListing\models\SearchOrder;
use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use Yii;
use yii\base\Model;
use yii\web\RangeNotSatisfiableHttpException;

class ExportForm extends Model
{
    /**
     * Экспорт спсика заказов и сервисов
     * @return void
     * @throws RangeNotSatisfiableHttpException
     */
    public function export(): void
    {
        $searchOrder = (new SearchOrder())->setModel(new Order());
        $searchOrder->load(Yii::$app->request->get(), '');
        ob_start();
        $output = fopen('php://output', 'w');
        $columns = array_map(fn(OrdersColumn $column): string => Yii::t('orders', $column->value), OrdersColumn::cases());
        fputcsv($output, $columns);
        foreach ($searchOrder->search()->each() as $model) {
            fputcsv($output, $model->toArray());
        }
        fclose($output);
        Yii::$app->getResponse()->sendContentAsFile(ob_get_clean(), 'orders_' . date('d.m.Y') . '.csv', ['mimeType' => 'text/csv']);
    }
}