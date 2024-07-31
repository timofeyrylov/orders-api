<?php

namespace OrderListing\models\query;

use OrderListing\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends ActiveQuery
{
    /**
     * @return array<User>
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @return array<User>|null
     */
    public function one($db = null): ?array
    {
        return parent::one($db);
    }
}
