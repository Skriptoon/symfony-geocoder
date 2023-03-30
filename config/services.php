<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Interfaces\GeocoderInterface;
use App\Services\Geocoder\YandexGeocoder;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

return function (ContainerConfigurator $containerConfigurator) {
    // default configuration for services in *this* file
    $services = $containerConfigurator->services()
        ->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    // makes classes in src/ available to be used as services
    // this creates a service per class whose id is the fully-qualified class name
    $services->load('App\\', '../src/')
        ->exclude('../src/{DependencyInjection,Entity,Kernel.php}');

    // order is important in this file because service definitions
    // always *replace* previous ones; add your own service configuration below

    $services->set(GeocoderInterface::class, YandexGeocoder::class)
        ->bind('string $apiKey', env('YANDEX_API_KEY')->string())
        ->arg('$client', service(HttpClientInterface::class))
        ->arg('$logger', service(LoggerInterface::class));
};