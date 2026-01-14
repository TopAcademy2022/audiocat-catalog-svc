<?php

declare(strict_types=1);

use App\Application\Actions\Artist\ListArtistsAction;
use App\Application\Actions\Artist\ViewArtistAction;
use App\Application\Actions\Artist\CreateArtistAction;
use App\Application\Actions\Artist\UpdateArtistAction;
use App\Application\Actions\Artist\PatchArtistAction;
use App\Application\Actions\Artist\DeleteArtistAction;

use App\Application\Actions\Track\ListTracksAction;
use App\Application\Actions\Track\ViewTrackAction;
use App\Application\Actions\Track\CreateTrackAction;
use App\Application\Actions\Track\UpdateTrackAction;
use App\Application\Actions\Track\PatchTrackAction;
use App\Application\Actions\Track\DeleteTrackAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $payload = [
            'service' => 'audiocat-catalog-svc',
            'status' => 'ok',
            'docs' => '/docs',
            'openapi' => '/openapi.json',
            'health' => '/health',
        ];

        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->group('/artists', function (Group $group) {
        $group->get('', ListArtistsAction::class);
        $group->post('', CreateArtistAction::class);

        $group->get('/{id}', ViewArtistAction::class);
        $group->put('/{id}', UpdateArtistAction::class);
        $group->patch('/{id}', PatchArtistAction::class);
        $group->delete('/{id}', DeleteArtistAction::class);
    });

    $app->group('/tracks', function (Group $group) {
        $group->get('', ListTracksAction::class);
        $group->post('', CreateTrackAction::class);

        $group->get('/{id}', ViewTrackAction::class);
        $group->put('/{id}', UpdateTrackAction::class);
        $group->patch('/{id}', PatchTrackAction::class);
        $group->delete('/{id}', DeleteTrackAction::class);
    });
};
