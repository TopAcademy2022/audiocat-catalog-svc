<?php

declare(strict_types=1);

namespace App\Domain\Track;

use App\Domain\DomainException\DomainRecordNotFoundException;

class TrackNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The track you requested does not exist.';
}
