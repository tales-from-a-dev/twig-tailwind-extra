<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use TalesFromADev\Twig\Extra\Tailwind\Bundle\DependencyInjection\TwigTailwindExtraExtension;

final class TwigTailwindExtraBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new TwigTailwindExtraExtension();
    }
}
