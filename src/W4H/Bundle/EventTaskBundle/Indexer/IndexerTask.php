<?php
namespace W4H\Bundle\EventTaskBundle\Indexer;

use W4H\Bundle\EventTaskBundle\Indexer\Indexer;
use EWZ\Bundle\SearchBundle\Lucene\Document;
use EWZ\Bundle\SearchBundle\Lucene\Field;

class IndexerTask extends Indexer
{
    /**
     * Write a task in the index search
     *
     * @param Task $task
     */
    public function writeDoc($task)
    {
        $doc = new Document();

        // Index task data
        $doc->addField(Field::keyword('key', $task->getId()));
        $doc->addField(Field::UnStored('activity', $task->getActivity()->getName()));
        $doc->addField(Field::UnStored('description', $task->getActivity()->getDescription()));
        foreach($task->getOwners() as $k => $task_owner)
        {
            $doc->addField(Field::UnStored(sprintf('first_name_%d', $k), $task_owner->getPerson()->getFirstName()));
            $doc->addField(Field::UnStored(sprintf('last_name_%d', $k), $task_owner->getPerson()->getLastName()));
        }

        foreach($task->getPaperPresenters() as $k => $paper_presenter)
        {
            $doc->addField(Field::UnStored(sprintf('paper_number_%d', $k), $paper_presenter->getPaper()->getPaperNumber()));
            $doc->addField(Field::UnStored(sprintf('paper_title_%d', $k), $paper_presenter->getPaper()->getTitle()));
        }

        // Add document to the index
        $this->search->addDocument($doc);
    }

    public function updateDoc($task)
    {
        $this->deleteDoc($task);
        $this->writeDoc($task);
    }
}
