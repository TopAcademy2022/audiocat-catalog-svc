<?php

declare(strict_types=1);

use App\Domain\Artist\ArtistRepository;
use App\Infrastructure\Persistence\Doctrine\Artist\DoctrineArtistRepository;

use App\Domain\Track\TrackRepository;
use App\Infrastructure\Persistence\Doctrine\Track\DoctrineTrackRepository;

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        ArtistRepository::class => \DI\autowire(DoctrineArtistRepository::class),
        TrackRepository::class => \DI\autowire(DoctrineTrackRepository::class),
    ]);
};
