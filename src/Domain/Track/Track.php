<?php

declare(strict_types=1);

namespace App\Domain\Track;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tracks')]
class Track implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid', unique: true)]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255)]
    private ?string $media_id;

    public function __construct(string $title, ?string $media_id)
    {
        $this->title = strtolower($title);
        $this->media_id = ucfirst($media_id);
    }

    public function getId(): string
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
