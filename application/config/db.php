<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mysql-service;dbname=' . $_ENV['MYSQL_DATABASE'],
    'username' => $_ENV['MYSQL_USER'],
    'password' => $_ENV['MYSQL_PASSWORD'],
    'charset' => 'utf8',
];
