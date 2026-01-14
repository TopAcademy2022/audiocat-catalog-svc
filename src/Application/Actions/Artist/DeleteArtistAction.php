<?php

declare(strict_types=1);

namespace App\Application\Actions\Artist;

use Psr\Http\Message\ResponseInterface as Response;

final class DeleteArtistAction extends ArtistAction
{
    protected function action(): Response
    {
        $artistId = $this->resolveArg('id');
        $artist = $this->artistRepository->findArtistOfId($artistId);

        $this->artistRepository->delete($artist);

        $this->logger->info("Artist of id {$artistId} was deleted.");

        return $this->respondWithData(null, 204);
    }
}
