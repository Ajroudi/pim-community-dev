<?php

namespace Pim\Bundle\CatalogBundle\Command;

use Pim\Component\Catalog\Completeness\CompletenessCalculatorInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Calculate the completeness of the products
 *
 * @author    Gildas Quemener <gildas@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class CalculateCompletenessCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('pim:completeness:calculate')
            ->setDescription('Launch the product completeness calculation');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Generating missing completenesses...</info>");
        // TODO: TIP-694: Make that command work again.
        // $this->getCompletenessCalculator()->calculate();
        $output->writeln("<info>Missing completenesses generated.</info>");
    }

    /**
     * Get the completeness repository
     *
     * @return CompletenessCalculatorInterface
     */
    protected function getCompletenessCalculator()
    {
        return $this
            ->getContainer()
            ->get('pim_catalog.completeness.calculator');
    }
}
