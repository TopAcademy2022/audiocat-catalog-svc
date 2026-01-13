<?php

declare(strict_types=1);

namespace App\Application\Actions\Track;

use Psr\Http\Message\ResponseInterface as Response;

class ListTracksAction extends TrackAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $tracks = $this->trackRepository->findAll();

        $this->logger->info("Tracks list was viewed.");

        return $this->respondWithData($tracks);
    }
}
