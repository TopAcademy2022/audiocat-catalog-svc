<?php

declare(strict_types=1);

namespace App\Domain\Artist;

use App\Domain\DomainException\DomainRecordNotFoundException;

class ArtistNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The artist you requested does not exist.';
}
