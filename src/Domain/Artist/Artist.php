<?php

declare(strict_types=1);

namespace App\Domain\Artist;

use JsonSerializable;

class Artist implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private ?string $description;

    public function __construct(?int $id, string $name, ?string $description)
    {
        $this->id = $id;
        $this->name = strtolower($name);
        $this->description = ucfirst($description);
    }

    public function getId(): ?int
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
