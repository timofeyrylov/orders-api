<?php

namespace OrderListing\models\query;

use OrderListing\models\Service;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Service]].
 *
 * @see Service
 */
class ServiceQuery extends ActiveQuery
{
    /**
     * @return array<Service>
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @return array<Service>|null
     */
    public function one($db = null): ?array
    {
        return parent::one($db);
    }
}
