<?php

declare(strict_types=1);

namespace App\Domain\Track;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'tracks')]
class Track implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid', unique: true)]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media_id;

    public function __construct(string $title, ?string $media_id)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->title = strtolower($title);
        $this->media_id = $media_id !== null ? trim($media_id) : null;
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

    public function rename(string $title): void
    {
        $title = trim($title);
        if ($title === '') {
            throw new \InvalidArgumentException('Track title cannot be empty.');
        }

        $this->title = strtolower($title);
    }

    public function changeMediaId(?string $mediaId): void
    {
        $this->media_id = $mediaId !== null ? trim($mediaId) : null;
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
