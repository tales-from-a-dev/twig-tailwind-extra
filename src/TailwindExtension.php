<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class TailwindExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('tailwind_merge', [TailwindRuntime::class, 'merge']),
        ];
    }
}
