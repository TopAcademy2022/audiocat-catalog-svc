<?php

declare(strict_types=1);

use DI\ContainerBuilder;

use App\Domain\Artist\ArtistRepository;
use App\Infrastructure\Persistence\Doctrine\Artist\DoctrineArtistRepository;

use App\Domain\Track\TrackRepository;
use App\Infrastructure\Persistence\Doctrine\Track\DoctrineTrackRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        ArtistRepository::class => \DI\autowire(DoctrineArtistRepository::class),
        TrackRepository::class => \DI\autowire(DoctrineTrackRepository::class),
    ]);
};
