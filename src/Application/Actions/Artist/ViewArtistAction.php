<?php

declare(strict_types=1);

namespace App\Application\Actions\Artist;

use Psr\Http\Message\ResponseInterface as Response;

class ViewArtistAction extends ArtistAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $artistId = (int) $this->resolveArg('id');
        $artist = $this->artistRepository->findArtistOfId($artistId);

        $this->logger->info("Artist of id `${artistId}` was viewed.");

        return $this->respondWithData($artist);
    }
}
