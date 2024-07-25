<?php

namespace app\components;

use yii\base\Widget;

class NavigationBar extends Widget
{
    public array $tabs = [];

    public function run(): string
    {
        return $this->render('@app/views/navigation/navigation', ['tabs' => $this->tabs]);
    }
}