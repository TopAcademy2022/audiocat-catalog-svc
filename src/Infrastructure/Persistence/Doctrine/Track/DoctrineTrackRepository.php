<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Track;

use App\Domain\Track\Track;
use App\Domain\Track\TrackNotFoundException;
use App\Domain\Track\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTrackRepository implements TrackRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return Track[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(Track::class)
            ->findAll();
    }

    public function findTrackOfId(string $id): Track
    {
        $track = $this->entityManager->find(Track::class, $id);

        if ($track === null) {
            throw new TrackNotFoundException($id);
        }

        return $track;
    }
}
