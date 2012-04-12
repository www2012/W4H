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
    public function getFilterName()      { return $this->getOption('filter_name') ? $this->getOption('filter_name') : 'lucene_search'; }
    public function getFilterFormType()  { return 'text'; }

    public function getFilterFormOptions()
    {
        return array(
            'label'    => $this->getOption('filter_form_label') ? $this->getOption('filter_form_label') : 'Keywords',
            'required' => false
        );
    }

    public function filter($filteredData)
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

    public function getDefaultFilteredData() { return array(); }
}
