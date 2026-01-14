<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Artist;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Handlers\HttpErrorHandler;
use App\Domain\Artist\Artist;
use App\Domain\Artist\ArtistNotFoundException;
use App\Domain\Artist\ArtistRepository;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

final class ViewArtistActionTest extends TestCase
{
    public function testAction(): void
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $artist = new Artist('Radiohead', 'English rock band');
        $artistId = $artist->getId();

        $artistRepositoryProphecy = $this->prophesize(ArtistRepository::class);
        $artistRepositoryProphecy
            ->findArtistOfId($artistId)
            ->willReturn($artist)
            ->shouldBeCalledOnce();

        $container->set(ArtistRepository::class, $artistRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', "/artists/{$artistId}");
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $artist);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsArtistNotFoundException(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        // Любой UUID-строковый id подойдёт; можно просто "missing-id"
        $missingId = 'missing-id';

        $artistRepositoryProphecy = $this->prophesize(ArtistRepository::class);
        $artistRepositoryProphecy
            ->findArtistOfId($missingId)
            ->willThrow(new ArtistNotFoundException($missingId))
            ->shouldBeCalledOnce();

        $container->set(ArtistRepository::class, $artistRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', "/artists/{$missingId}");
        $response = $app->handle($request);

        $payload = (string) $response->getBody();

        // Сообщение должно совпадать с тем, что формирует твой HttpErrorHandler для ArtistNotFoundException.
        $expectedError = new ActionError(
            ActionError::RESOURCE_NOT_FOUND,
            'The artist you requested does not exist.'
        );

        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
