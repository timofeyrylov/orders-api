<?php

namespace OrderListing\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 */
class User extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 300],
        ];
    }

    /**
     * @return array<>
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('orders', 'ID'),
            'first_name' => Yii::t('orders', 'First Name'),
            'last_name' => Yii::t('orders', 'Last Name'),
        ];
    }
}