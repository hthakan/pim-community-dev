<?php

declare(strict_types=1);

namespace Akeneo\Pim\Enrichment\Component\Product\Connector\Writer\Database;

use Akeneo\Tool\Bundle\VersioningBundle\Manager\VersionManager;
use Akeneo\Tool\Component\Batch\Item\ItemWriterInterface;
use Akeneo\Tool\Component\Batch\Model\StepExecution;
use Akeneo\Tool\Component\Batch\Step\StepExecutionAwareInterface;
use Akeneo\Tool\Component\StorageUtils\Saver\BulkSaverInterface;

/**
 * Product model saver, define custom logic and options for product model saving
 *
 * @author    Arnaud Langlade <arnaud.langlade@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ProductModelWriter implements ItemWriterInterface, StepExecutionAwareInterface
{
    protected VersionManager $versionManager;
    protected StepExecution $stepExecution;
    protected BulkSaverInterface $productModelSaver;

    public function __construct(
        VersionManager $versionManager,
        BulkSaverInterface $productModelSaver
    ) {
        $this->versionManager = $versionManager;
        $this->productModelSaver = $productModelSaver;
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $items): void
    {
        $jobParameters = $this->stepExecution->getJobParameters();
        $realTimeVersioning = $jobParameters->get('realTimeVersioning');
        $this->versionManager->setRealTimeVersioning($realTimeVersioning);
        foreach ($items as $productModel) {
            $action = $productModel->getId() ? 'process' : 'create';
            $this->stepExecution->incrementSummaryInfo($action);
        }

        $parameters = $this->stepExecution->getJobParameters();
        $origin = $parameters->has('origin') ? $parameters->get('origin') : null;

        $this->productModelSaver->saveAll($items,  ['origin' => $origin]);
    }

    /**
     * {@inheritdoc}
     */
    public function setStepExecution(StepExecution $stepExecution): void
    {
        $this->stepExecution = $stepExecution;
    }
}
