<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Contracts\Cache\CacheInterface;
use TalesFromADev\TailwindMerge\TailwindMerge;
use Twig\Extension\RuntimeExtensionInterface;

final class TailwindRuntime implements RuntimeExtensionInterface
{
    private TailwindMerge $merger;

    public function __construct(
        array $additionalConfiguration = [],
        ?CacheInterface $cache = null,
    ) {
        $cache ??= new FilesystemAdapter();

        $this->merger = new TailwindMerge(
            additionalConfiguration: $additionalConfiguration,
            cache: new Psr16Cache($cache),
        );
    }

    public function merge(string|array|null $classes): string
    {
        return $this->merger->merge($classes);
    }
}
