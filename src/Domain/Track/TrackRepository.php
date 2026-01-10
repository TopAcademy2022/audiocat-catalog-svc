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
     * @param int $id
     * @return Track
     * @throws TrackNotFoundException
     */
    public function findTrackOfId(int $id): Track;
}
