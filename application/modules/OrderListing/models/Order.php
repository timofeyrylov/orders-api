<?php

namespace app\modules\OrderListing\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    /**
     * Имя пользователя
     * @var string
     */
    public string $userName;

    /**
     * Название сервиса
     * @var string
     */
    public string $serviceName;

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{orders}}';
    }

    /**
     * @return OrderQuery
     * @throws InvalidConfigException
     */
    public static function find(): OrderQuery
    {
        return Yii::createObject(OrderQuery::class, [get_called_class()])
            ->select(['orders.id', 'concat(u.first_name, " ", u.last_name) as userName', 'link', 'quantity', 's.name as serviceName', 'status', 'created_at', 'mode'])
            ->joinWith('user u', false)
            ->joinWith('service s', false);
    }
}