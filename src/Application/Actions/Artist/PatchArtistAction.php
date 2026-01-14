<?php

declare(strict_types=1);

namespace App\Application\Actions\Artist;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;

final class PatchArtistAction extends ArtistAction
{
    protected function action(): Response
    {
        $artistId = $this->resolveArg('id');
        $artist = $this->artistRepository->findArtistOfId($artistId);

        $data = $this->getJsonBody();

        if ($data === null) {
            return $this->respondWithData(['message' => 'Invalid JSON in request body.'], 400);
        }

        try {
            if (array_key_exists('name', $data)) {
                $name = trim((string) $data['name']);
                if ($name === '') {
                    return $this->respondWithData(['message' => 'Field "name" cannot be empty.'], 422);
                }
                $artist->rename($name);
            }

            if (array_key_exists('description', $data)) {
                $description = $data['description'];
                if ($description !== null) {
                    $description = (string) $description;
                }
                $artist->changeDescription($description);
            }
        } catch (InvalidArgumentException $e) {
            return $this->respondWithData(['message' => $e->getMessage()], 422);
        }

        $this->artistRepository->save($artist);

        $this->logger->info("Artist of id {$artistId} was patched (PATCH).");

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
