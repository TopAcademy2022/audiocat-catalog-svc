<?php

declare(strict_types=1);

namespace App\Domain\Track;

interface TrackRepository
{
    /**
     * @return Track[]
     */
    public function findAll(): array;

    /**
     * @param string $id
     * @return Track
     * @throws TrackNotFoundException
     */
    public function findTrackOfId(string $id): Track;
}
