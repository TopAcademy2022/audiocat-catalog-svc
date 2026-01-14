<?php

declare(strict_types=1);

namespace App\Application\Actions\Artist;

use App\Domain\Artist\Artist;
use Psr\Http\Message\ResponseInterface as Response;

final class CreateArtistAction extends ArtistAction
{
    protected function action(): Response
    {
        $data = $this->getJsonBody();

        $name = (string) ($data['name'] ?? '');
        $name = trim($name);

        if ($name === '') {
            return $this->respondWithData(['message' => 'Field "name" is required.'], 422);
        }

        $description = $data['description'] ?? null;
        if ($description !== null) {
            $description = (string) $description;
        }

        $artist = new Artist($name, $description);

        $this->artistRepository->save($artist);

        $artistId = $artist->getId();
        $this->logger->info("Artist created with id {$artistId}.");

        return $this
            ->respondWithData($artist, 201)
            ->withHeader('Location', "/artists/{$artistId}");
    }

    /**
     * @return array<string, mixed>
     */
    private function getJsonBody(): array
    {
        $raw = (string) $this->request->getBody();
        if ($raw === '') {
            return [];
        }

        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
}
