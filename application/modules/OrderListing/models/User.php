<?php

namespace app\modules\OrderListing\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{users}}';
    }
}