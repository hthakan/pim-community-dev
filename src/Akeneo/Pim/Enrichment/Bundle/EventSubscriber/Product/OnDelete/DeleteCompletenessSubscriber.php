<?php

declare(strict_types=1);

namespace Akeneo\Pim\Enrichment\Bundle\EventSubscriber\Product\OnDelete;

use Akeneo\Pim\Enrichment\Bundle\Doctrine\Common\Remover\CompletenessRemover;
use Akeneo\Pim\Enrichment\Component\Product\Model\ProductInterface;
use Akeneo\Tool\Component\StorageUtils\Event\RemoveEvent;
use Akeneo\Tool\Component\StorageUtils\StorageEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Removes completness information related to deleted product.
 *
 * @author    Grégoire HUBERT <gregoire.hubert@akeneo.com>
 * @copyright 2020 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
final class DeleteCompletenessSubscriber implements EventSubscriberInterface
{
    /** @var CompletenessRemover */
    private $completenessRemover;

    public function __construct(CompletenessRemover $completenessRemover)
    {
        $this->completenessRemover = $completenessRemover;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() : array
    {
        return [
            StorageEvents::POST_REMOVE      => 'deleteProduct',
            StorageEvents::POST_REMOVE_ALL  => 'deleteAllProducts',
        ];
    }

    public function deleteProduct(RemoveEvent $event) : void
    {
        $product = $event->getSubject();
        if (!$this->checkProduct($product) || !$this->checkEventUnitary($event)) {
            return;
        }

        $this->completenessRemover
            ->deleteOneProduct($event->getSubjectId());
    }

    public function deleteAllProducts(RemoveEvent $event)
    {
        $products = $event->getSubject();
        if (!is_array($products) || !is_array($event->getSubjectId())) {
            return;
        }
        $products = array_filter($products, function ($product) {
            return $this->checkProduct($product);
        });
        if (!empty($products)) {
            $this->completenessRemover->deleteProducts($products);
        }
    }

    private function checkProduct($product): bool
    {
        return $product instanceof ProductInterface
            // TODO TIP-987 Remove this when decoupling PublishedProduct from Enrichment
            && get_class($product) != 'Akeneo\Pim\WorkOrganization\Workflow\Component\Model\PublishedProduct';
    }

    private function checkEventUnitary(RemoveEvent $event): bool
    {
        return $event->hasArgument('unitary')
            && true === $event->getArgument('unitary');
    }
}
