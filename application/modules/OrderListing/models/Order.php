<?php

namespace OrderListing\models;

use OrderListing\models\query\OrderQuery;
use OrderListing\thesaurus\codes\ColumnThesaurus as OrdersColumn;
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
     * @return array<string>
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('orders', OrdersColumn::ID->value),
            'user_id' => Yii::t('orders', OrdersColumn::User->value),
            'link' => Yii::t('orders', OrdersColumn::Link->value),
            'quantity' => Yii::t('orders', OrdersColumn::Quantity->value),
            'service_id' => Yii::t('orders', OrdersColumn::Service->value),
            'status' => Yii::t('orders', OrdersColumn::Status->value),
            'created_at' => Yii::t('orders', OrdersColumn::Created->value),
            'mode' => Yii::t('orders', OrdersColumn::Mode->value),
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
