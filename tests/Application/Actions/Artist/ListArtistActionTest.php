<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Artist;

use App\Application\Actions\ActionPayload;
use App\Domain\Artist\Artist;
use App\Domain\Artist\ArtistRepository;
use DI\Container;
use Tests\TestCase;

final class ListArtistActionTest extends TestCase
{
    public function testAction(): void
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $artist = new Artist('Radiohead', 'English rock band');

        $artistRepositoryProphecy = $this->prophesize(ArtistRepository::class);
        $artistRepositoryProphecy
            ->findAll()
            ->willReturn([$artist])
            ->shouldBeCalledOnce();

        $container->set(ArtistRepository::class, $artistRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/artists');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$artist]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
