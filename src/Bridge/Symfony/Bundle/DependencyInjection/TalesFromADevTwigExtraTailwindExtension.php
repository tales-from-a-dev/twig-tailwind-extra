<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class TalesFromADevTwigExtraTailwindExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('tailwind.php');

        $twigRuntimeTailwindDefinition = $container->getDefinition('twig.runtime.tailwind');
        $twigRuntimeTailwindDefinition->setArgument(0, $mergedConfig['tailwind_merge']['additional_configuration']);
    }
}
