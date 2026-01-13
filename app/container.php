<?php

declare(strict_types=1);

use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Подключаем те же файлы, что и приложение
$settings = require __DIR__ . '/settings.php';
$settings($containerBuilder);

(require __DIR__ . '/dependencies.php')($containerBuilder);
(require __DIR__ . '/repositories.php')($containerBuilder);

$container = $containerBuilder->build();

return $container;
