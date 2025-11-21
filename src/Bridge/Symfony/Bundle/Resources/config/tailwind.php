<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;

use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set('twig.cache.tailwind')
            ->parent('cache.app')
            ->tag('cache.pool', ['name' => 'twig.cache'])

        ->set('twig.extension.tailwind', TailwindExtension::class)
            ->tag('twig.extension')

        ->set('twig.runtime.tailwind', TailwindRuntime::class)
            ->args([
                abstract_arg('additional configuration, set in TalesFromADevTwigExtraTailwindExtension'),
                service('twig.cache.tailwind'),
            ])
            ->tag('twig.runtime')
    ;
};
