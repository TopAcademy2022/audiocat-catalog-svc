<?php

declare(strict_types=1);

use App\Domain\Artist\ArtistRepository;
use App\Infrastructure\Persistence\Artist\InMemoryArtistRepository;

use App\Domain\Track\TrackRepository;
use App\Infrastructure\Persistence\Track\InMemoryTrackRepository;

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        ArtistRepository::class => \DI\autowire(InMemoryArtistRepository::class),
        TrackRepository::class => \DI\autowire(InMemoryTrackRepository::class),
    ]);
};
