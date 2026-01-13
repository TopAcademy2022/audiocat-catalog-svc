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
     * @param string $id
     * @return Artist
     * @throws ArtistNotFoundException
     */
    public function findArtistOfId(string $id): Artist;
}
