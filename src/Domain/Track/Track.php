<?php

declare(strict_types=1);

namespace App\Domain\Track;

use JsonSerializable;

class Track implements JsonSerializable
{
    private ?int $id;

    private string $title;

    private ?string $media_id;

    public function __construct(?int $id, string $title, ?string $media_id)
    {
        $this->id = $id;
        $this->title = strtolower($title);
        $this->media_id = ucfirst($media_id);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMediaId(): ?string
    {
        return $this->media_id;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'media_id' => $this->media_id
        ];
    }
}
