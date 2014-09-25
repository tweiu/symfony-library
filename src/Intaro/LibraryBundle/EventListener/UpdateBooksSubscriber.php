<?php

namespace Intaro\LibraryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UpdateBooksSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postRemove',
            'postUpdate',
            'postPersist'
        );
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->clearBooksCache($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->clearBooksCache($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->clearBooksCache($args);
    }

    public function clearBooksCache(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('books');
    }
}
