<?php

declare(strict_types=1);

use DI\ContainerBuilder;

use App\Domain\Artist\ArtistRepository;
use App\Infrastructure\Persistence\Doctrine\Artist\DoctrineArtistRepository;

use App\Domain\Track\TrackRepository;
use App\Infrastructure\Persistence\Doctrine\Track\DoctrineTrackRepository;

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        ArtistRepository::class => \DI\autowire(DoctrineArtistRepository::class),
        TrackRepository::class => \DI\autowire(DoctrineTrackRepository::class),
    ]);
};
