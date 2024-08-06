<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Contracts\Cache\CacheInterface;
use TailwindMerge\Factory;
use TailwindMerge\TailwindMerge;
use Twig\Extension\RuntimeExtensionInterface;

final class TailwindRuntime implements RuntimeExtensionInterface
{
    private Factory $factory;

    public function __construct(CacheInterface $cache = null)
    {
        $cache ??= new FilesystemAdapter();

        $this->factory = TailwindMerge::factory()->withCache(new Psr16Cache($cache));
    }

    public function merge(string|array|null $classes, array $configuration = []): string
    {
        return $this->factory
            ->withConfiguration($configuration)
            ->make()
            ->merge($classes)
        ;
    }
}
