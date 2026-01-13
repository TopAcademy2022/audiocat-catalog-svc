<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;

use App\Application\Actions\Artist\ListArtistsAction;
use App\Application\Actions\Artist\ViewArtistAction;

use App\Application\Actions\Track\ListTracksAction;
use App\Application\Actions\Track\ViewTrackAction;

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
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/artists', function (Group $group) {
        $group->get('', ListArtistsAction::class);
        $group->get('/{id}', ViewArtistAction::class);
    });

    $app->group('/tracks', function (Group $group) {
        $group->get('', ListTracksAction::class);
        $group->get('/{id}', ViewTrackAction::class);
    });
};
