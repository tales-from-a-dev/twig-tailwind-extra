<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TalesFromADev\Twig\Extra\Tailwind\Bundle\DependencyInjection\TwigTailwindExtraExtension;

final class TwigTailwindExtraBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new TwigTailwindExtraExtension();
    }
}
