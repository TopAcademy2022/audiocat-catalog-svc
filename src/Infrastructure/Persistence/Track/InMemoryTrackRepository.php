<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Track;

use App\Domain\Track\Track;
use App\Domain\Track\TrackNotFoundException;
use App\Domain\Track\TrackRepository;

class InMemoryTrackRepository implements TrackRepository
{
    /**
     * @var Track[]
     */
    private array $tracks;

    /**
     * @param Track[]|null $tracks
     */
    public function __construct(array $tracks = null)
    {
        $this->tracks = $tracks ?? [
            1 => new Track(1, 'Conventional Commits', '1kd4glk8rme'),
            2 => new Track(2, 'Git flow', 'b2dm7lkeler'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->tracks);
    }

    /**
     * {@inheritdoc}
     */
    public function findTrackOfId(int $id): Track
    {
        if (!isset($this->tracks[$id])) {
            throw new TrackNotFoundException();
        }

        return $this->tracks[$id];
    }
}
