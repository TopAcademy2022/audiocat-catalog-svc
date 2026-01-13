<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

require_once __DIR__ . '/../vendor/autoload.php';

// Идеально — вынести сборку контейнера в app/container.php.
$container = require __DIR__ . '/../app/container.php';

/** @var EntityManagerInterface $em */
$em = $container->get(EntityManagerInterface::class);

$tool = new SchemaTool($em);
$metadata = $em->getMetadataFactory()->getAllMetadata();

if (count($metadata) === 0) {
    fwrite(STDERR, "No metadata found. Check metadata_dirs / entity mapping.\n");
    exit(1);
}

$command = $argv[1] ?? null;

switch ($command) {
    case 'create':
        $tool->createSchema($metadata);
        echo "Schema created.\n";
        break;

    case 'update':
        // true = safe mode (not destructive). false = may drop columns etc.
        $tool->updateSchema($metadata, true);
        echo "Schema updated (safe mode).\n";
        break;

    case 'recreate':
        $tool->dropSchema($metadata);
        $tool->createSchema($metadata);
        echo "Schema recreated (drop + create).\n";
        break;

    default:
        echo "Usage:\n";
        echo "  php bin/schema.php create\n";
        echo "  php bin/schema.php update\n";
        echo "  php bin/schema.php recreate\n";
        exit(0);
}
