<?php

declare(strict_types=1);

namespace App\Domain\Artist;

use App\Domain\DomainException\DomainRecordNotFoundException;

final class ArtistNotFoundException extends DomainRecordNotFoundException
{
    public function __construct(string $artistId = '')
    {
        parent::__construct('The artist you requested does not exist.');
    }
}
