# Getting started

## Prerequisites

This extension requires **PHP 8.1+**, **Twig 3.0+** and **Tailwind 4.0+**.

## Installation

You can install the extension using Composer:

```bash
composer require tales-from-a-dev/twig-tailwind-extra
```

### Symfony

If you are using Symfony Flex, this is done automatically, otherwise register the bundle into `config/bundles.php`:

```php
// config/bundles.php

return [
    // ...
    TalesFromADev\Twig\Extra\Tailwind\Bridge\Symfony\Bundle\TalesFromADevTwigExtraTailwindBundle::class => ['all' => true],
];
```

### Standalone

If you use Twig as standalone, then you need to add the extension manually

```php
$extension = new \TalesFromADev\Twig\Extra\Tailwind\TailwindExtension();

$twig = new \Twig\Environment($loader);

$twig->addRuntimeLoader(new \Twig\RuntimeLoader\FactoryRuntimeLoader([
    \TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime::class => fn () => new \TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime(),
]));

$twig->addExtension($extension);
```

## Usage

The following filters are available

* [TailwindExtension](./src/TailwindExtension.php)
    * tailwind_merge() Integration of [tailwind-merge-php](https://github.com/tales-from-a-dev/tailwind-merge-php)
    * tailwind_classes() Build a `TailwindClassList` for mergeable Tailwind classes (implements Twig HTML-Extra's `MergeableInterface`)

## Examples

### Default

```twig
{{ 'text-red-500 text-blue-500'|tailwind_merge }} // 'text-blue-500'
```

### With an array of classes

```twig
{{ ['block', 'inline']|tailwind_merge }} // 'inline'
```

### With a custom configuration

#### Symfony

```yaml
# config/packages/tales_from_a_dev_twig_extra_tailwind.yaml

tales_from_a_dev_twig_extra_tailwind:
    tailwind_merge:
        additional_configuration:
            prefix: tw
```

#### Standalone

```php
$twig->addRuntimeLoader(new \Twig\RuntimeLoader\FactoryRuntimeLoader([
    \TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime::class => fn () => new \TalesFromADev\Twig\Extra\Tailwind\TailwindRuntime([
        'prefix' => 'tw',
    ]),
]));
```

Then simply call the filter in your templates:

```twig
{{ 'tw:text-red-500 tw:text-blue-500'|tailwind_merge }} // 'tw:text-blue-500'
```

### Tailwind classes

Unlike `tailwind_merge`, which eagerly merges and returns a string, `tailwind_classes` returns a `TailwindClassList` object. The actual merge is deferred until the value is rendered, so classes coming from several merge steps (e.g. a component's default classes merged with caller-provided classes) are deduplicated in a single pass, with the right-most value winning conflicts.

`TailwindClassList` implements Twig HTML-Extra's `MergeableInterface`, so it merges correctly through `html_attr()`/`html_attr_merge()`:

```twig
{{ 'px-4 py-2 bg-red-500 bg-blue-500'|tailwind_classes }} // 'px-4 py-2 bg-blue-500'

{{ html_attr({ class: 'px-4 py-2 bg-blue-500'|tailwind_classes }, { class: 'bg-red-500' }) }}
// class="px-4 py-2 bg-red-500"

{{ null|tailwind_classes }} // (renders nothing, the attribute is omitted)
```
