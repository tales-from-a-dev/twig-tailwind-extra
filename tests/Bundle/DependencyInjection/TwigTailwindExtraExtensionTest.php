<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Tests\Bundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use TalesFromADev\Twig\Extra\Tailwind\Bundle\DependencyInjection\TwigTailwindExtraExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;

final class TwigTailwindExtraExtensionTest extends TestCase
{
    public function testDefaultConfiguration()
    {
        $container = new ContainerBuilder(new ParameterBag([
            'kernel.debug' => false,
        ]));
        $container->registerExtension(new TwigTailwindExtraExtension());
        $container->loadFromExtension('twig_tailwind_extra');
        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);
        $container->getCompilerPassConfig()->setAfterRemovingPasses([]);
        $container->compile();

        $this->assertEquals(TailwindExtension::class, $container->getDefinition('twig.extension.tailwind')->getClass());
        $this->assertEquals(TailwindRuntime::class, $container->getDefinition('twig.runtime.tailwind')->getClass());
    }
}
