<?php
namespace W4H\Bundle\EventTaskBundle\Indexer;

class Indexer
{
    protected $search;
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
        $this->search = $this->container->get('ewz_search.lucene');
    }

    public function update()
    {
        $this->search->updateIndex();
    }

    public function deleteDoc($entity)
    {
        $hits = $this->search->find("".$entity->getId()."");
        $index = $this->search->getIndex();
        foreach ($hits as $hit)
        {
            $index->delete($hit->id);
        }
    }
}
