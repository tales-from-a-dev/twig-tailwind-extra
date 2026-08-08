<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Tests;

use PHPUnit\Framework\TestCase;
use TalesFromADev\TailwindMerge\TailwindMerge;
use TalesFromADev\Twig\Extra\Tailwind\TailwindClassList;
use TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime;

final class TailwindClassListTest extends TestCase
{
    private function classList(mixed $classes): TailwindClassList
    {
        return new TailwindClassList(new TailwindMerge(), $classes);
    }

    public function testGetValueMergesAndDeduplicates(): void
    {
        $this->assertSame('py-2 bg-blue-500', $this->classList('py-2 bg-red-500 bg-blue-500')->getValue());
        $this->assertSame('py-2 bg-blue-500', $this->classList(['py-2', 'bg-red-500', 'bg-blue-500'])->getValue());
    }

    public function testGetValueReturnsNullWhenEmpty(): void
    {
        $this->assertNull($this->classList([])->getValue());
        $this->assertNull($this->classList(null)->getValue());
    }

    public function testToStringRendersTheMergedValue(): void
    {
        $this->assertSame('py-2 bg-blue-500', (string) $this->classList('py-2 bg-red-500 bg-blue-500'));
        $this->assertSame('', (string) $this->classList([]));
    }

    public function testAppendFromLetsTheNewValueWinConflicts(): void
    {
        $default = $this->classList('px-4 py-2 bg-blue-500');

        $this->assertSame('px-4 py-2 bg-red-500', $default->appendFrom('bg-red-500')->getValue());
        $this->assertSame('px-4 py-2 bg-red-500', $default->appendFrom(['bg-red-500'])->getValue());
    }

    public function testMergeIntoLetsTheReceiverWinConflicts(): void
    {
        // $this is on the right-hand side of $previous, so it wins conflicts.
        $override = $this->classList('bg-red-500');

        $this->assertSame('px-4 py-2 bg-red-500', $override->mergeInto('px-4 py-2 bg-blue-500')->getValue());
        $this->assertSame('px-4 py-2 bg-red-500', $override->mergeInto($this->classList('px-4 py-2 bg-blue-500'))->getValue());
    }

    public function testMergeIsImmutable(): void
    {
        $default = $this->classList('px-4 bg-blue-500');

        $default->appendFrom('bg-red-500');
        $default->mergeInto('bg-green-500');

        $this->assertSame('px-4 bg-blue-500', $default->getValue());
    }

    public function testRuntimeClassesFactory(): void
    {
        $runtime = new TailwindRuntime();

        $this->assertInstanceOf(TailwindClassList::class, $runtime->classes('px-4 py-2'));
        $this->assertSame('px-4 py-2 bg-red-500', $runtime->classes('px-4 py-2 bg-blue-500')->appendFrom('bg-red-500')->getValue());
        $this->assertNull($runtime->classes()->getValue());
    }
}
