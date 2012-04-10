<?php
namespace W4H\Bundle\EventTaskBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use W4H\Bundle\EventTaskBundle\Entity\Task;

class IndexManagerListener
{
    protected $container;
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof Task)
        {
            $indexer_task = $this->container->get('w4h.indexer.task');
            $indexer_task->writeDoc($entity);
            $indexer_task->update();
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof Task)
        {
            $indexer_task = $this->container->get('w4h.indexer.task');
            $indexer_task->updateDoc($entity);
            $indexer_task->update();
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof Task)
        {
            $indexer_task = $this->container->get('w4h.indexer.task');
            $indexer_task->deleteDoc($entity);
            $indexer_task->update();
        }
    }
}
