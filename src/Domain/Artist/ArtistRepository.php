<?php

declare(strict_types=1);

namespace App\Domain\Artist;

interface ArtistRepository
{
    /**
     * @return Artist[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Artist
     * @throws ArtistNotFoundException
     */
    public function findArtistOfId(int $id): Artist;
}
