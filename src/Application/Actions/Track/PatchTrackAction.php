<?php

declare(strict_types=1);

namespace App\Application\Actions\Track;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;

final class PatchTrackAction extends TrackAction
{
    protected function action(): Response
    {
        $trackId = $this->resolveArg('id');
        $track = $this->trackRepository->findTrackOfId($trackId);

        $data = $this->getJsonBody();
        
        if ($data === null) {
            return $this->respondWithData(['message' => 'Invalid JSON in request body.'], 400);
        }

        try {
            if (array_key_exists('title', $data)) {
                $title = trim((string) $data['title']);
                if ($title === '') {
                    return $this->respondWithData(['message' => 'Field "title" cannot be empty.'], 422);
                }
                $track->rename($title);
            }

            if (array_key_exists('media_id', $data)) {
                $mediaId = $data['media_id'];
                if ($mediaId !== null) {
                    $mediaId = (string) $mediaId;
                }
                $track->changeMediaId($mediaId);
            }
        } catch (InvalidArgumentException $e) {
            return $this->respondWithData(['message' => $e->getMessage()], 422);
        }

        $this->trackRepository->save($track);

        $this->logger->info("Track of id {$trackId} was patched (PATCH).");

        return $this->respondWithData($track);
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
