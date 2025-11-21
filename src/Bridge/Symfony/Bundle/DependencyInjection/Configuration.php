<?php

declare(strict_types=1);

namespace TalesFromADev\Twig\Extra\Tailwind\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('tales_from_a_dev_twig_extra_tailwind');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('tailwind_merge')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('additional_configuration')
                            ->defaultValue([])
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
