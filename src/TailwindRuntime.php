<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind;

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use TailwindMerge\Factory;
use TailwindMerge\TailwindMerge;
use Twig\Extension\RuntimeExtensionInterface;

final class TailwindRuntime implements RuntimeExtensionInterface
{
    private Factory $factory;

    public function __construct(
        CacheInterface $cache = null,
    ) {
        $cache ??= new Psr16Cache(new FilesystemAdapter());

        $this->factory = TailwindMerge::factory()->withCache($cache);
    }

    public function merge(string|array $classes, array $configuration = []): string
    {
        return $this->factory
            ->withConfiguration($configuration)
            ->make()
            ->merge($classes)
        ;
    }
}
