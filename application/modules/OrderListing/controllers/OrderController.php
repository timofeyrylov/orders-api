<?php

namespace OrderListing\controllers;

use OrderListing\controllers\actions\ExportAction;
use OrderListing\controllers\actions\ListingAction;
use yii\web\Controller;

class OrderController extends Controller
{
    public function actions(): array
    {
        return [
            'listing' => ListingAction::class,
            'export' => ExportAction::class
        ];
    }
}