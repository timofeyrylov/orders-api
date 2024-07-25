<?php /** @var array $tabs */

use yii\helpers\Url; ?>

<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <?php foreach ($tabs as $name => $route): ?>
                <li class="active"><a href="<?= Url::toRoute([$route]) ?>"><?= $name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>