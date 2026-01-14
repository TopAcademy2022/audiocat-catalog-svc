<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Artist;

use App\Domain\Artist\Artist;
use App\Domain\Artist\ArtistNotFoundException;
use App\Domain\Artist\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineArtistRepository implements ArtistRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return Artist[]
     */
    public function findAll(): array
    {
        return $this->entityManager
            ->getRepository(Artist::class)
            ->findAll();
    }

    public function findArtistOfId(string $id): Artist
    {
        $artist = $this->entityManager->find(Artist::class, $id);

        if ($artist === null) {
            throw new ArtistNotFoundException($id);
        }

        return $artist;
    }

    public function save(Artist $artist): void
    {
        $this->entityManager->persist($artist);
        $this->entityManager->flush();
    }

    public function delete(Artist $artist): void
    {
        $this->entityManager->remove($artist);
        $this->entityManager->flush();
    }
}
