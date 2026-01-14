<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Doctrine\Artist;

use App\Domain\Artist\Artist;
use App\Domain\Artist\ArtistNotFoundException;
use App\Infrastructure\Persistence\Doctrine\Artist\DoctrineArtistRepository;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Tests\TestCase;

final class DoctrineArtistRepositoryTest extends TestCase
{
    private EntityManager $em;
    private DoctrineArtistRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();

        // 1) Doctrine config: attributes mapping
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/../../../../../src/Domain'],
            isDevMode: true
        );

        // 2) SQLite in-memory (fast, no files)
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ], $config);

        $this->em = new EntityManager($connection, $config);

        // 3) Create schema for all mapped entities
        $schemaTool = new SchemaTool($this->em);
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);

        $this->repo = new DoctrineArtistRepository($this->em);
    }

    protected function tearDown(): void
    {
        // Clean up
        if (isset($this->em)) {
            $schemaTool = new SchemaTool($this->em);
            $metadata = $this->em->getMetadataFactory()->getAllMetadata();
            $schemaTool->dropSchema($metadata);

            $this->em->close();
        }

        parent::tearDown();
    }

    public function testFindAllInitiallyEmpty(): void
    {
        $this->assertSame([], $this->repo->findAll());
    }

    public function testSaveAndFindAll(): void
    {
        $artist = new Artist('Radiohead', 'English rock band');

        $this->repo->save($artist);

        $all = $this->repo->findAll();

        $this->assertCount(1, $all);
        $this->assertInstanceOf(Artist::class, $all[0]);

        $this->assertSame($artist->getId(), $all[0]->getId());
        $this->assertSame($artist->getName(), $all[0]->getName());
        $this->assertSame($artist->getDescription(), $all[0]->getDescription());
    }

    public function testFindArtistOfId(): void
    {
        $artist = new Artist('Daft Punk', 'French electronic music duo');
        $this->repo->save($artist);

        $found = $this->repo->findArtistOfId($artist->getId());

        $this->assertSame($artist->getId(), $found->getId());
        $this->assertSame($artist->getName(), $found->getName());
        $this->assertSame($artist->getDescription(), $found->getDescription());
    }

    public function testFindArtistOfIdThrowsNotFoundException(): void
    {
        $this->expectException(ArtistNotFoundException::class);
        $this->repo->findArtistOfId('missing-id');
    }

    public function testDeleteRemovesArtist(): void
    {
        $artist = new Artist('Muse', 'English rock band');
        $this->repo->save($artist);

        $this->assertCount(1, $this->repo->findAll());

        $this->repo->delete($artist);

        $this->assertSame([], $this->repo->findAll());

        $this->expectException(ArtistNotFoundException::class);
        $this->repo->findArtistOfId($artist->getId());
    }
}
