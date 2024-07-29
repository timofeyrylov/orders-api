<?php

namespace OrderListing\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Service extends ActiveRecord
{
    /**
     * Колиство заказов по данному сервису
     * @var int|null
     */
    public ?int $amount = null;

    /**
     * @return Query
     */
    public function getOrders(): Query
    {
        return $this->hasMany(Order::class, ['service_id' => 'id']);
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'services';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * @return ServiceQuery
     * @throws InvalidConfigException
     */
    public static function find(): ServiceQuery
    {
        return Yii::createObject(ServiceQuery::class, [get_called_class()]);
    }
}