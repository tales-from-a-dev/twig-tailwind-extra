<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set('twig.extension.tailwind', TailwindExtension::class)
        ->tag('twig.extension')

        ->set('twig.runtime.tailwind', TailwindRuntime::class)
        ->args([
            service('twig.cache'),
        ])
        ->tag('twig.runtime')
    ;
};
