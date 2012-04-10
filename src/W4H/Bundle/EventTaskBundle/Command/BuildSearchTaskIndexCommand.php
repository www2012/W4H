<?php
namespace W4H\Bundle\EventTaskBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildSearchTaskIndexCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('w4h:build-search-task-index');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Building the task search index...');
        $insertions = 0;

        $indexer_task = $this->getContainer()->get('w4h.indexer.task');
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        foreach($em->getRepository('W4HEventTaskBundle:Task')->findAll() as $task)
        {
            $indexer_task->writeDoc($task);
            $output->writeln(sprintf('%d > Inserted "%s"', ++$insertions, $task));
        }
        $indexer_task->update();
        $output->writeln(sprintf('The tasks search index has been rebuilt, %d tasks processed', $insertions));
     }
}
