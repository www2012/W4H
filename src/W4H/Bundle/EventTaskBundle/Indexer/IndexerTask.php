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
        $doc->addField(Field::text('activity', $task->getActivity()->getName()));
        $doc->addField(Field::text('description', $task->getActivity()->getDescription()));
        foreach($task->getOwners() as $task_owner)
        {
            $doc->addField(Field::text('first_name', $task_owner->getPerson()->getFirstName()));
            $doc->addField(Field::text('last_name', $task_owner->getPerson()->getLastName()));
        }

        foreach($task->getPaperPresenters() as $paper_presenter)
        {
            $doc->addField(Field::text('paper_number', $paper_presenter->getPaper()->getPaperNumber()));
            $doc->addField(Field::text('paper_title', $paper_presenter->getPaper()->getTitle()));
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
