<?php

declare(strict_types=1);

namespace App\Domain\Artist;

use App\Domain\DomainException\DomainRecordNotFoundException;

final class ArtistNotFoundException extends DomainRecordNotFoundException
{
    private string $artistId;

    public function __construct(string $artistId)
    {
        parent::__construct('The artist you requested does not exist.');
        $this->artistId = $artistId;
    }

    public function getArtistId(): string
    {
        return $this->artistId;
    }
}
