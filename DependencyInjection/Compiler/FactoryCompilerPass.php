<?php
/*
 * This file licensed under the MIT license.
 *
 * (c) Sylvain Mauduit <swop@swop.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlphaLabs\Bundle\FilterEngineBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Register factories into the chained factory
 *
 * @package AlphaLabs\Bundle\FilterEngineBundle\DependencyInjection\Compiler
 *
 * @author  Sylvain Mauduit <swop@swop.io>
 */
class FactoryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('alphalabs_filter_engine.filter_bag.factory.chained')) {
            return;
        }

        $definition = $container->getDefinition(
            'alphalabs_filter_engine.filter_bag.factory.chained'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'alphalabs_filter_engine.factory'
        );

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addFactory',
                    array(new Reference($id), $attributes['priority'])
                );
            }
        }
    }
}
