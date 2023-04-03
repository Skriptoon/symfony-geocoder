<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Interfaces\GeocoderInterface;
use App\Services\Geocoder\YandexGeocoder;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

return function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', '../src/')
        ->exclude('../src/{DependencyInjection,Entity,Kernel.php}');

    $services->set(GeocoderInterface::class, YandexGeocoder::class)
        ->bind('string $apiKey', env('YANDEX_API_KEY')->string())
        ->arg('$client', service(HttpClientInterface::class))
        ->arg('$logger', service(LoggerInterface::class));
};