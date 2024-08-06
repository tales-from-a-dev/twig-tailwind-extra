<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Tests\Bridge\Symfony\Bundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use TalesFromADev\Twig\Extra\Tailwind\Bridge\Symfony\Bundle\DependencyInjection\TalesFromADevTwigExtraTailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;

final class TalesFromADevTwigExtraTailwindExtensionTest extends TestCase
{
    public function testDefaultConfiguration(): void
    {
        $container = new ContainerBuilder(new ParameterBag([
            'kernel.debug' => false,
        ]));
        $container->registerExtension(new TalesFromADevTwigExtraTailwindExtension());
        $container->loadFromExtension('tales_from_a_dev_twig_extra_tailwind');
        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);
        $container->getCompilerPassConfig()->setAfterRemovingPasses([]);
        $container->compile();

        $this->assertEquals(TailwindExtension::class, $container->getDefinition('twig.extension.tailwind')->getClass());
        $this->assertEquals(TailwindRuntime::class, $container->getDefinition('twig.runtime.tailwind')->getClass());
    }
}
