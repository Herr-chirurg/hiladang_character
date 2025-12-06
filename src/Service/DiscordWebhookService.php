<?php

// src/Service/DiscordWebhookService.php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DiscordWebhookService
{
    public function __construct(private HttpClientInterface $http)
    {
    }

    public function send(string $webhookUrl, string $message): void
    {
        $this->http->request('POST', $webhookUrl, [
            'json' => [
                'content' => $message,
            ],
        ]);
    }
}