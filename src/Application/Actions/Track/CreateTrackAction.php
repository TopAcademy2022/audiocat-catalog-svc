<?php

declare(strict_types=1);

namespace App\Application\Actions\Track;

use App\Domain\Track\Track;
use Psr\Http\Message\ResponseInterface as Response;

final class CreateTrackAction extends TrackAction
{
    protected function action(): Response
    {
        $data = $this->getJsonBody();

        $title = trim((string) ($data['title'] ?? ''));
        if ($title === '') {
            return $this->respondWithData(['message' => 'Field "title" is required.'], 422);
        }

        $mediaId = $data['media_id'] ?? null;
        if ($mediaId !== null) {
            $mediaId = (string) $mediaId;
        }

        $track = new Track($title, $mediaId);

        $this->trackRepository->save($track);

        $trackId = $track->getId();
        $this->logger->info("Track created with id {$trackId}.");

        return $this
            ->respondWithData($track, 201)
            ->withHeader('Location', "/tracks/{$trackId}");
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
