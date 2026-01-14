<?php

declare(strict_types=1);

namespace App\Application\Actions\Track;

use Psr\Http\Message\ResponseInterface as Response;

final class DeleteTrackAction extends TrackAction
{
    protected function action(): Response
    {
        $trackId = $this->resolveArg('id');
        $track = $this->trackRepository->findTrackOfId($trackId);

        $this->trackRepository->delete($track);

        $this->logger->info("Track of id {$trackId} was deleted.");

        return $this->respondWithData(null, 204);
    }
}
