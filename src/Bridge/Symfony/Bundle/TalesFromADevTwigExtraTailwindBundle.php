<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Bridge\Symfony\Bundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use TalesFromADev\Twig\Extra\Tailwind\Bridge\Symfony\Bundle\DependencyInjection\TalesFromADevTwigExtraTailwindExtension;

final class TalesFromADevTwigExtraTailwindBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new TalesFromADevTwigExtraTailwindExtension();
    }
}
