<?php

declare(strict_types=1);

namespace App\Application\Actions\Track;

use App\Application\Actions\Action;
use App\Domain\Track\TrackRepository;
use Psr\Log\LoggerInterface;

abstract class TrackAction extends Action
{
    protected TrackRepository $trackRepository;

    public function __construct(LoggerInterface $logger, TrackRepository $trackRepository)
    {
        parent::__construct($logger);
        $this->trackRepository = $trackRepository;
    }
}
