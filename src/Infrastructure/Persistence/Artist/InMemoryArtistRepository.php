<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Artist;

use App\Domain\Artist\Artist;
use App\Domain\Artist\ArtistNotFoundException;
use App\Domain\Artist\ArtistRepository;

class InMemoryArtistRepository implements ArtistRepository
{
    /**
     * @var Artist[]
     */
    private array $artists;

    /**
     * @param Artist[]|null $artists
     */
    public function __construct(array $artists = null)
    {
        $this->artists = $artists ?? [
            1 => new Artist(1, 'Aisha', 'Some description.'),
            2 => new Artist(2, 'Ilona Maks', 'some description.'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->artists);
    }

    /**
     * {@inheritdoc}
     */
    public function findArtistOfId(int $id): Artist
    {
        if (!isset($this->artists[$id])) {
            throw new ArtistNotFoundException();
        }

        return $this->artists[$id];
    }
}
