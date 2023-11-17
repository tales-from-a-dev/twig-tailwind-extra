<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Tests;

use PHPUnit\Framework\TestCase;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;

final class FunctionalTest extends TestCase
{
    public function testItCanMergeStringClasses(): void
    {
        $runtime = new TailwindRuntime();

        $this->assertSame('text-blue-500', $runtime->merge('text-red-500 text-blue-500'));
        $this->assertSame('inline', $runtime->merge('block inline'));
    }

    public function testItCanMergeArrayClasses(): void
    {
        $runtime = new TailwindRuntime();

        $this->assertSame('text-blue-500', $runtime->merge(['text-red-500', 'text-blue-500']));
        $this->assertSame('inline', $runtime->merge(['block', 'inline']));
    }

    public function testItCanMergeWithConfiguration(): void
    {
        $runtime = new TailwindRuntime();

        $this->assertSame('tw-text-blue-500', $runtime->merge(['tw-text-red-500', 'tw-text-blue-500'], ['prefix' => 'tw-']));
    }
}
