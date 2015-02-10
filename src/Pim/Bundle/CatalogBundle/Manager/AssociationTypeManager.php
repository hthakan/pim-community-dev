<?php

namespace Pim\Bundle\CatalogBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;
use Akeneo\Component\StorageUtils\Saver\SaverInterface;
use Akeneo\Component\StorageUtils\Remover\RemoverInterface;
use Pim\Bundle\CatalogBundle\Event\AssociationTypeEvents;
use Pim\Bundle\CatalogBundle\Model\AssociationTypeInterface;
use Pim\Bundle\CatalogBundle\Repository\AssociationTypeRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Association type manager
 *
 * @author    Romain Monceau <romain@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AssociationTypeManager
{
    /** @var AssociationTypeRepositoryInterface $repository */
    protected $repository;

    /** @var ObjectManager */
    protected $objectManager;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param AssociationTypeRepositoryInterface $repository
     * @param ObjectManager                      $objectManager
     * @param EventDispatcherInterface           $eventDispatcher
     */
    public function __construct(
        AssociationTypeRepositoryInterface $repository,
        ObjectManager $objectManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->repository      = $repository;
        $this->objectManager   = $objectManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get association types
     *
     * @return array
     */
    public function getAssociationTypes()
    {
        return $this->repository->findAll();
    }
}
