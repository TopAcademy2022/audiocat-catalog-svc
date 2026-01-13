<?php

declare(strict_types=1);

namespace App\Application\Actions\Track;

use Psr\Http\Message\ResponseInterface as Response;

class ViewTrackAction extends TrackAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $trackId = (int) $this->resolveArg('id');
        $track = $this->trackRepository->findTrackOfId($trackId);

        $this->logger->info("Track of id `${trackId}` was viewed.");

        return $this->respondWithData($track);
    }
}
