<?php

namespace AlphaLabs\Bundle\FilterEngineBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AlphaLabsFilterEngineExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $declarationFiles = ['filter.xml'];

        foreach ($declarationFiles as $file) {
            $loader->load($file);
        }

        $this->configureFilters($config['filters'], $container);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'alphalabs_filter_engine';
    }

    /**
     * @param array            $config    Filters configuration
     * @param ContainerBuilder $container Container
     */
    private function configureFilters(array $config, ContainerBuilder $container)
    {
        $requestBasedFactoryDefinition = $container->getDefinition(
            'alphalabs_filter_engine.filter_bag.factory.request_based'
        );

        $requestBasedFactoryDefinition->replaceArgument(1, $config['filter_key']);
    }
}
