<?php

declare(strict_types=1);

namespace App\Application\Actions\Artist;

use App\Application\Actions\Action;
use App\Domain\Artist\ArtistRepository;
use Psr\Log\LoggerInterface;

abstract class ArtistAction extends Action
{
    protected ArtistRepository $artistRepository;

    public function __construct(LoggerInterface $logger, ArtistRepository $artistRepository)
    {
        parent::__construct($logger);
        $this->artistRepository = $artistRepository;
    }
}
