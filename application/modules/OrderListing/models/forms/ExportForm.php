<?php

namespace OrderListing\models\forms;

use OrderListing\models\search\OrderSearch;
use OrderListing\models\Service;
use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
use OrderListing\thesaurus\ModeThesaurus;
use OrderListing\thesaurus\SearchTypeThesaurus;
use OrderListing\thesaurus\StatusThesaurus;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\RangeNotSatisfiableHttpException;

class ExportForm extends Model
{
    /**
     * Статус заказа
     * @var string|null
     */
    public ?string $status = '';

    /**
     * Тип поиска
     * @var string
     */
    public string $searchType = '';

    /**
     * Поисковый запрос
     * @var int|string|null
     */
    public int|string|null $searchValue = null;

    /**
     * Режим заказа
     * @var string
     */
    public string $mode = '';

    /**
     * Id сервиса
     * @var int|null
     */
    public $serviceId = null;

    /**
     * @return array<>
     */
    public function rules(): array
    {
        return [
            ['status', 'in', 'range' => array_map(fn(StatusThesaurus $status): string => $status->value, StatusThesaurus::cases())],
            ['searchType', 'in', 'range' => array_map(fn(SearchTypeThesaurus $searchType): string => $searchType->value, SearchTypeThesaurus::cases())],
            ['searchValue', 'integer', 'when' => fn(): bool => $this->searchType === SearchTypeThesaurus::OrderId->value],
            ['searchValue', 'string', 'when' => fn(): bool => $this->searchType === SearchTypeThesaurus::Link->value],
            ['searchValue', 'string', 'when' => fn(): bool => $this->searchType === SearchTypeThesaurus::UserName->value],
            ['searchValue', 'default', 'value' => null],
            ['mode', 'in', 'range' => array_map(fn(ModeThesaurus $mode): string => $mode->value, ModeThesaurus::cases())],
            ['serviceId', 'integer'],
            ['serviceId', 'default', 'value' => null],
            ['serviceId', 'exist', 'targetClass' => Service::class, 'targetAttribute' => ['serviceId' => 'id']]
        ];
    }

    /**
     * Экспорт спсика заказов и сервисов
     * @return string
     * @throws RangeNotSatisfiableHttpException|Exception
     */
    public function export(): string
    {
        $orderSearch = new OrderSearch();
        if (!$orderSearch->load($this->getAttributes(), '') || !$orderSearch->validate()) {
            throw new Exception('Invalid parameters: ' . implode(' ', $orderSearch->getErrorSummary(true)));
        }
        ob_start();
        $output = fopen('php://output', 'w');
        $columns = array_map(fn(OrdersColumn $column): string => Yii::t('orders', $column->value), OrdersColumn::cases());
        fputcsv($output, $columns);
        foreach ($orderSearch->search(batch: true) as $models) {
            foreach ($models as $model) {
                fputcsv($output, [
                    $model['id'],
                    $model['first_name'] . ' ' . $model['last_name'],
                    $model['link'],
                    $model['quantity'],
                    $model['name'],
                    Yii::t('orders', StatusThesaurus::getStatusName($model['status'])),
                    ModeThesaurus::getModeName($model['mode']),
                    date('Y-m-d H:i:s', $model['created_at'])
                ]);
            }
        }
        fclose($output);
        return ob_get_clean();
    }
}