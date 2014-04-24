<?php

namespace AlphaLabs\Bundle\FilterEngineBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('alphalabs_filter_engine')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('filters')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('filter_key')
                            ->info('Filter expression key to seek in request')
                            ->example('_filter')
                            ->defaultValue('_filter')
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
