<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Tests;

use TalesFromADev\Twig\Extra\Tailwind\TailwindExtension;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\Test\IntegrationTestCase;

final class IntegrationTest extends IntegrationTestCase
{
    public function getExtensions(): array
    {
        return [
            new TailwindExtension(),
        ];
    }

    protected function getRuntimeLoaders(): array
    {
        return [
            new class() implements RuntimeLoaderInterface {
                public function load($class): ?TailwindRuntime
                {
                    if (TailwindRuntime::class === $class) {
                        return new TailwindRuntime();
                    }

                    return null;
                }
            },
        ];
    }

    protected function getFixturesDir(): string
    {
        return __DIR__.'/Fixtures/';
    }
}
