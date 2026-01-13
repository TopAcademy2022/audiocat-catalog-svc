<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],

                'doctrine' => [
                    'dev_mode' => true,

                    // Где Doctrine ищет entities (attributes)
                    'metadata_dirs' => [
                        __DIR__ . '/../src/Domain',
                    ],

                    // Прокси-классы Doctrine
                    'proxy_dir' => __DIR__ . '/../var/cache/doctrine/proxy',

                    // SQLite
                    'driver' => 'pdo_sqlite',
                    'path' => __DIR__ . '/../var/data/audiocat.sqlite',
                ],
            ]);
        }
    ]);
};
