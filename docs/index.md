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
