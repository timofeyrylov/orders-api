<?php

namespace OrderListing\models;

use OrderListing\models\query\ServiceQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Service extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'services';
    }

    /**
     * @return array<>
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
     */
    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['service_id' => 'id']);
    }

    /**
     * @return array<>
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('orders', 'ID'),
            'name' => Yii::t('orders', 'Name'),
        ];
    }

    /**
     * @return ServiceQuery the active query used by this AR class.
     */
    public static function find(): ServiceQuery
    {
        return new ServiceQuery(get_called_class());
    }
}
