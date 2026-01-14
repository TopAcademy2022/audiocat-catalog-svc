<?php

declare(strict_types=1);

namespace App\Application\Actions\Artist;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;

final class UpdateArtistAction extends ArtistAction
{
    protected function action(): Response
    {
        $artistId = $this->resolveArg('id');
        $artist = $this->artistRepository->findArtistOfId($artistId);

        $data = $this->getJsonBody();

        if ($data === null) {
            return $this->respondWithData(['message' => 'Invalid JSON in request body.'], 400);
        }

        $name = trim((string) ($data['name'] ?? ''));
        if ($name === '') {
            return $this->respondWithData(['message' => 'Field "name" is required for PUT.'], 422);
        }

        // description должен присутствовать (даже если null), иначе это скорее PATCH
        if (!array_key_exists('description', $data)) {
            return $this->respondWithData(['message' => 'Field "description" is required for PUT (can be null).'], 422);
        }

        $description = $data['description'];
        if ($description !== null) {
            $description = (string) $description;
        }

        try {
            $artist->rename($name);
            $artist->changeDescription($description);
        } catch (InvalidArgumentException $e) {
            return $this->respondWithData(['message' => $e->getMessage()], 422);
        }

        $this->artistRepository->save($artist);

        $this->logger->info("Artist of id {$artistId} was updated (PUT).");

        return $this->respondWithData($artist);
    }

    /**
     * @return array<string, mixed>|null Returns null if JSON parsing fails
     */
    private function getJsonBody(): ?array
    {
        $raw = (string) $this->request->getBody();
        if ($raw === '') {
            return [];
        }

        $data = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return is_array($data) ? $data : [];
    }
}
