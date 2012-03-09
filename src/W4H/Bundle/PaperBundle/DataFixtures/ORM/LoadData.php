<?php
namespace W4H\Bundle\PaperBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use W4H\Bundle\PaperBundle\Entity\Paper;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**************************************/
        // Paper
        /**************************************/
        $rows = array();
        if (($handle = fopen("src/W4H/Bundle/PaperBundle/DataFixtures/Data/paper.csv", "r")) !== FALSE) {
          $count = 0;
          while (($data = fgetcsv($handle, 5000, ",", '"')) !== FALSE) {
            list($session, $paper_number, $title, $subtitle, $number_of_page, $abstract, $author_first_name, $author_middle_name, $author_last_name, $author_mail, $affiliations, $affiliation_location) = $data;

            $author = sprintf('%s %s <%s>', $author_first_name, $author_last_name, $author_mail);

            if(empty($session) && empty($paper_number) && empty($title) && empty($subtitle) && empty($number_of_page) && empty($abstract)) {
              printf("\tNew author: %s\n", $author);
              $rows[$count-1]['authors'] .= ', '.$author;
            } else {
              printf("New paper: %s\n", $paper_number);
               printf("\tNew author: %s\n", $author);
              $rows[$count] = array(
                'paper_number'  => $paper_number,
                'title'         => $title,
                'authors'       => $author,
              );
              $count++;
            }
          }

          fclose($handle);
        }

        $papers = array();
        foreach($rows as $k => $row)
        {
          $papers[$k] = new Paper();
          $papers[$k]->setPaperNumber($row['paper_number']);
          $papers[$k]->setTitle($row['title']);
          $papers[$k]->setAuthors($row['authors']);
          $manager->persist($papers[$k]);
        }

        $manager->flush();
    }
}
