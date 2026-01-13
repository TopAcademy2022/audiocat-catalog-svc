<?php

declare(strict_types=1);

namespace App\Domain\Artist;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'artists')]
class Artist implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid', unique: true)]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private ?string $description;

    public function __construct(string $name, ?string $description)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = strtolower($name);
        $this->description = $description !== null
            ? ucfirst($description)
            : null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}
