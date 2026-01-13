<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Application\Settings\SettingsInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

final class EntityManagerFactory
{
    public function __invoke(ContainerInterface $container): EntityManager
    {
        /** @var SettingsInterface $settings */
        $settings = $container->get(SettingsInterface::class);

        $doctrine = $settings->get('doctrine');

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $doctrine['metadata_dirs'],
            isDevMode: (bool) $doctrine['dev_mode'],
            proxyDir: $doctrine['proxy_dir'] ?? null,
            cache: null
        );

        // SQLite connection
        $connection = DriverManager::getConnection([
            'driver' => $doctrine['driver'], // pdo_sqlite
            'path' => $doctrine['path'],
        ], $config);

        return new EntityManager($connection, $config);
    }
}
