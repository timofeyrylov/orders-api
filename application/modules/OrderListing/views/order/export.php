<?php

use app\thesaurus\codes\ExportThesaurus as ApplicationExport;
use yii\helpers\Url;

?>

<button class="btn btn-th btn-default" type="button">
    <a href="<?= Url::toRoute([
        "/export/" . Yii::$app->request->get('status'),
        'serviceId' => Yii::$app->request->get('serviceId'),
        'searchType' => Yii::$app->request->get('searchType'),
        'searchValue' => Yii::$app->request->get('searchValue'),
        'mode' => Yii::$app->request->get('mode')
    ]) . '/' ?>"><?= Yii::t('application', ApplicationExport::Save->value) ?></a>
</button>