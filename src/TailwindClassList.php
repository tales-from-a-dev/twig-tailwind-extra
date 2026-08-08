<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind;

use TalesFromADev\TailwindMerge\TailwindMergeInterface;
use Twig\Extra\Html\HtmlAttr\AttributeValueInterface;
use Twig\Extra\Html\HtmlAttr\MergeableInterface;

/**
 * A lazy, mergeable list of Tailwind classes.
 *
 * The actual `tailwind_merge` is deferred to {@see getValue()} so that classes coming from
 * several merge steps (e.g. a component default merged with caller-provided classes) are
 * deduplicated in a single pass, with the right-most value winning conflicts.
 */
final class TailwindClassList implements \Stringable, AttributeValueInterface, MergeableInterface
{
    /** @var list<mixed> */
    private array $classes;

    public function __construct(
        private readonly TailwindMergeInterface $merger,
        mixed $classes,
    ) {
        $this->classes = self::toClasses($classes);
    }

    public function __toString(): string
    {
        return $this->getValue() ?? '';
    }

    public function getValue(): ?string
    {
        return '' === ($merged = $this->merger->merge(...$this->classes)) ? null : $merged;
    }

    public function mergeInto(mixed $previous): mixed
    {
        return new self($this->merger, [...self::toClasses($previous), ...$this->classes]);
    }

    public function appendFrom(mixed $newValue): mixed
    {
        return new self($this->merger, [...$this->classes, ...self::toClasses($newValue)]);
    }

    /**
     * @return list<mixed>
     */
    private static function toClasses(mixed $value): array
    {
        if ($value instanceof self) {
            return $value->classes;
        }

        return is_iterable($value) ? [...$value] : [$value];
    }
}
