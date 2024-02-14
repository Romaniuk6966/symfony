<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class LoggerService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function info(string $message, array $context): void
    {
        $message .= ' TEST';
        $this->logger->info($message, $context);
    }

    public function error(string $message, array $context): void
    {
        $message .= ' TEST';
        $this->logger->error($message, $context);
    }
}
