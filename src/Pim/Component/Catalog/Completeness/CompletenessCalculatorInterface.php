<?php

namespace Pim\Component\Catalog\Completeness;

use Pim\Component\Catalog\Model\CompletenessInterface;
use Pim\Component\Catalog\Model\ProductInterface;

/**
 * @author    Damien Carcel (damien.carcel@akeneo.com)
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
interface CompletenessCalculatorInterface
{

    /**
     * Generates a two dimensional array of completenesses indexed by locale and channel.
     *
     * @param ProductInterface $product
     *
     * @return CompletenessInterface[]
     */
    public function calculate(ProductInterface $product);
}
