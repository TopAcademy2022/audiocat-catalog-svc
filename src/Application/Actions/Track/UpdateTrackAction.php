<?php

declare(strict_types=1);

namespace App\Application\Actions\Track;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;

final class UpdateTrackAction extends TrackAction
{
    protected function action(): Response
    {
        $trackId = $this->resolveArg('id');
        $track = $this->trackRepository->findTrackOfId($trackId);

        $data = $this->getJsonBody();

        $title = trim((string) ($data['title'] ?? ''));
        if ($title === '') {
            return $this->respondWithData(['message' => 'Field "title" is required for PUT.'], 422);
        }

        if (!array_key_exists('media_id', $data)) {
            return $this->respondWithData(
                ['message' => 'Field "media_id" is required for PUT (can be null).'],
                422
            );
        }

        $mediaId = $data['media_id'];
        if ($mediaId !== null) {
            $mediaId = (string) $mediaId;
        }

        try {
            $track->rename($title);
            $track->changeMediaId($mediaId);
        } catch (InvalidArgumentException $e) {
            return $this->respondWithData(['message' => $e->getMessage()], 422);
        }

        $this->trackRepository->save($track);

        $this->logger->info("Track of id {$trackId} was updated (PUT).");

        return $this->respondWithData($track);
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
