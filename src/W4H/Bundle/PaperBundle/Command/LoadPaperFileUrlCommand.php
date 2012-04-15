<?php
namespace W4H\Bundle\PaperBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadPaperFileUrlCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('w4h:load-paper-file-url')
             ->setDescription('Add paper file url in Paper table')
             ->addArgument('csv', InputArgument::REQUIRED, 'The csv file path to import')
             ->setHelp(<<<EOF
The <info>w4h:load-paper-file-url</info> command add paper file url in Paper table base on a given csv for a given environment:

<info>php app/console w4h:load-paper-file-url csv-file-path.csv --env=dev [Default]</info>
<info>php app/console w4h:load-paper-file-url csv-file-path.csv --env=prod</info>
EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $csv = $input->getArgument('csv');

        if (($handle = fopen($csv, "r")))
        {
            $em = $this->getContainer()->get('doctrine')->getEntityManager();
            $output->writeln('Loading paper file url...');
            $map =  array('paper_number', 'file_url');
            $updated = 0;

            while ($data = fgetcsv($handle, 0, ';', '"'))
            {
                if(count($data) == count($map))
                {
                    $data = array_combine($map, $data);
                    $papers = $em->getRepository('W4HPaperBundle:Paper')->findBy(array('paper_number' => $data['paper_number']));
                    if(isset($papers[0]) && $paper = $papers[0])
                    {
                        $paper->setFileUrl($data['file_url']);
                        $em->persist($paper);
                        $output->writeln(sprintf('%d > Updated paper "%s"', ++$updated, $paper->getPaperNumber()));
                    }
                }
            }
            $em->flush();
            $output->writeln(sprintf('Operation done, %d papers updated', $updated));
        }
    }
}
