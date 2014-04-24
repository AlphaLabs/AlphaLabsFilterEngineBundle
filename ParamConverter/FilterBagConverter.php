<?php
/*
 * This file licensed under the MIT license.
 *
 * (c) Sylvain Mauduit <swop@swop.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AlphaLabs\Bundle\FilterEngineBundle\ParamConverter;

use AlphaLabs\FilterEngine\Provider\FilterBagProviderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Param converter used to fetch filter bag
 *
 * @package AlphaLabs\Bundle\FilterEngineBundle\ParamConverter
 *
 * @author  Sylvain Mauduit <swop@swop.io>
 */
class FilterBagConverter implements ParamConverterInterface
{
    /** @const string */
    const FILTER_BAG_CLASS
        = "AlphaLabs\\FilterEngine\\FilterBag\\FilterBagInterface";

    /** @var  FilterBagProviderInterface */
    protected $filterBagProviderProvider;

    /**
     * Sets the filter bag provider
     *
     * @param FilterBagProviderInterface $filterBagProviderProvider
     *
     * @return $this
     */
    public function setFilterBagProviderProvider(
        FilterBagProviderInterface $filterBagProviderProvider
    ) {
        $this->filterBagProviderProvider = $filterBagProviderProvider;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    function apply(Request $request, ParamConverter $paramConverter)
    {
        $param = $paramConverter->getName();

        $filterBag = $this->filterBagProviderProvider->getFilterBag();

        $request->attributes->set($param, $filterBag);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    function supports(ParamConverter $paramConverter)
    {
        if (null === $paramConverter->getClass()) {
            return false;
        }

        return static::FILTER_BAG_CLASS === $paramConverter->getClass();
    }
}
