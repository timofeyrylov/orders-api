<?php

namespace OrderListing\models;

use OrderListing\models\query\OrderQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status 0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail
 * @property int $created_at
 * @property int $mode 0 - Manual, 1 - Auto
 */
class Order extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'orders';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id', 'link', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'required'],
            [['user_id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['link'], 'string', 'max' => 300],
        ];
    }

    /**
     * @return OrderQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return OrderQuery
     */
    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('orders', 'ID'),
            'user_id' => Yii::t('orders', 'User ID'),
            'link' => Yii::t('orders', 'Link'),
            'quantity' => Yii::t('orders', 'Quantity'),
            'service_id' => Yii::t('orders', 'Service ID'),
            'status' => Yii::t('orders', '0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail'),
            'created_at' => Yii::t('orders', 'Created At'),
            'mode' => Yii::t('orders', '0 - Manual, 1 - Auto'),
        ];
    }

    /**
     * @return OrderQuery the active query used by this AR class.
     */
    public static function find(): OrderQuery
    {
        return new OrderQuery(get_called_class());
    }
}
