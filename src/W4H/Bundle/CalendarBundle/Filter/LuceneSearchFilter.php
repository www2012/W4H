<?php
namespace W4H\Bundle\CalendarBundle\Filter;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class LuceneSearchFilter extends AbstractFilter
{
    public function getFilterName()      { return $this->getOption('filter_name') ? $this->getOption('filter_name') : 'lucene_query'; }
    public function getFilterFormType()  { return 'text'; }

    public function getFilterFormOptions()
    {
        return array(
            'label'    => $this->getOption('filter_form_label') ? $this->getOption('filter_form_label') : 'Keywords',
            'required' => false
        );
    }

    public function getFilteredData($filteredData = null)
    {
        if($filteredData != null)
        {
            $search = $this->getContainer()->get('ewz_search.lucene');
            $hits = $search->find($filteredData);
            $ids = array();
            if($hits)
            {
                foreach ($hits as $hit)
                    $ids[] = $hit->key;
            }

            return $ids;
        }

        return array();
    }
}
