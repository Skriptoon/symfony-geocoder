<?php

declare(strict_types=1);

namespace App\Services\Geocoder;

use App\Interfaces\GeocoderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class YandexGeocoder implements GeocoderInterface
{
    public function __construct(
        private string              $apiKey,
        private HttpClientInterface $client,
        private LoggerInterface     $logger,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function search(string $query): array
    {
        $response = $this->client->request(
            'GET',
            'https://geocode-maps.yandex.ru/1.x',
            [
                'query' => [
                    'geocode' => $query,
                    'apikey' => $this->apiKey,
                    'json' => true,
                ],
                'json' => true,
            ]
        );

        return $response->toArray();
    }
}