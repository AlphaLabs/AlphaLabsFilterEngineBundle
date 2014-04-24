<?php

namespace AlphaLabs\Bundle\FilterEngineBundle;

use AlphaLabs\Bundle\FilterEngineBundle\DependencyInjection\AlphaLabsFilterEngineExtension;
use AlphaLabs\Bundle\FilterEngineBundle\DependencyInjection\Compiler\FactoryCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlphaLabsFilterEngineBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new AlphaLabsFilterEngineExtension();
        }

        return $this->extension;
    }

    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FactoryCompilerPass());
    }
}
