<?php

declare(strict_types=1);

namespace App\Application\Actions\Artist;

use Psr\Http\Message\ResponseInterface as Response;

class ListArtistsAction extends ArtistAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $artists = $this->artistRepository->findAll();

        $this->logger->info("Artists list was viewed.");

        return $this->respondWithData($artists);
    }
}
