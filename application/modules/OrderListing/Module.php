<?php

namespace app\modules\OrderListing;

use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $layout = '@app/modules/OrderListing/views/layouts/main.php';

    /**
     * Инициализация модуля
     * @return void
     */
    public function init(): void
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Конфигурация перевода
     * @return void
     */
    public function registerTranslations(): void
    {
        Yii::$app->i18n->translations['modules/OrderListing/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@app/modules/OrderListing/messages',
            'fileMap' => [
                'modules/OrderListing/listing' => 'listing.php',
            ]
        ];
    }

    /**
     * Действия перед выполнением методов контроллера
     * @param $action
     * @return true
     */
    public function beforeAction($action): true
    {
        Yii::$app->language = Yii::$app->request->get('language');
        return parent::beforeAction($action);
    }

    /**
     * Перевод текста
     * @param string $category - Категория текста
     * @param string $message - Текст
     * @param array $params - Параметры, заменяющие плейсхолдеры
     * @param string|null $language - Код языка
     * @return string
     */
    public static function translate(string $category, string $message, array $params = [], string $language = null): string
    {
        return Yii::t('modules/OrderListing/' . $category, $message, $params, $language);
    }
}