<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Tests\Bridge\Symfony\Bundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use TalesFromADev\Twig\Extra\Tailwind\Bridge\Symfony\Bundle\DependencyInjection\TalesFromADevTwigExtraTailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;

final class TalesFromADevTwigExtraTailwindExtensionTest extends TestCase
{
    public static function getFormats(): array
    {
        return [
            ['php'],
            ['yml'],
        ];
    }

    public function testDefaultConfiguration(): void
    {
        $container = $this->createContainer();
        $container->registerExtension(new TalesFromADevTwigExtraTailwindExtension());
        $container->loadFromExtension('tales_from_a_dev_twig_extra_tailwind');
        $this->compileContainer($container);

        $this->assertEquals(TailwindExtension::class, $container->getDefinition('twig.extension.tailwind')->getClass());
        $this->assertEquals(TailwindRuntime::class, $container->getDefinition('twig.runtime.tailwind')->getClass());
        $this->assertEmpty($container->getDefinition('twig.runtime.tailwind')->getArgument(0));
    }

    /**
     * @dataProvider getFormats
     */
    public function testAdditionalConfiguration(string $fileFormat): void
    {
        $container = $this->createContainer();
        $container->registerExtension(new TalesFromADevTwigExtraTailwindExtension());
        $this->loadFromFile($container, 'additional-configuration', $fileFormat);
        $this->compileContainer($container);

        $this->assertEquals(TailwindExtension::class, $container->getDefinition('twig.extension.tailwind')->getClass());
        $this->assertEquals(TailwindRuntime::class, $container->getDefinition('twig.runtime.tailwind')->getClass());
        $this->assertEquals(
            [
                'prefix' => 'tw',
                'theme' => [],
                'classGroups' => [
                    'fooKey' => ['otherKey'],
                    'otherKey' => ['fooKey', 'fooKey2'],
                ],
                'conflictingClassGroups' => [
                    'fooKey' => ['otherKey'],
                    'otherKey' => ['fooKey', 'fooKey2'],
                ],
            ],
            $container->getDefinition('twig.runtime.tailwind')->getArgument(0)
        );
    }

    private function createContainer(): ContainerBuilder
    {
        return new ContainerBuilder(new ParameterBag([
            'kernel.cache_dir' => __DIR__,
            'kernel.build_dir' => __DIR__,
            'kernel.project_dir' => __DIR__,
            'kernel.charset' => 'UTF-8',
            'kernel.debug' => false,
        ]));
    }

    private function compileContainer(ContainerBuilder $container): void
    {
        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);
        $container->getCompilerPassConfig()->setAfterRemovingPasses([]);
        $container->compile();
    }

    private function loadFromFile(ContainerBuilder $container, string $file, string $format): void
    {
        $locator = new FileLocator(__DIR__.'/Fixtures/'.$format);

        $loader = match ($format) {
            'php' => new PhpFileLoader($container, $locator),
            'yml' => new YamlFileLoader($container, $locator),
        };

        $loader->load($file.'.'.$format);
    }
}
