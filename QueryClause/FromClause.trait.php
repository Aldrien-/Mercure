<?php

namespace Project\DataSources\Mercure\QueryClause;

/**
 * @brief The FROM clause of the query.
 */
trait FromClause
{
    use Clause;
    
    /**
     * @brief The array of classes used in the FROM clause of the query.
     * @var Array.
     */
    protected $from = array();

    /**
     * @brief Add classes in the FROM clause of the query.
     * @param Mixed $classeNames The array of classes' names.
	 * @return Mixed The query.
     *
     * @details
     * Use :
     * - from('Class')
     * - from('Class1', 'Class2')
     * - from(array('Class1', 'Class2'))
     */
    public function from($classeNames)
    {
        if(!is_array($classeNames))
        {
            $classeNames = func_get_args();
        }

        foreach($classeNames as $className)
        {
            $this->from[] = $className;
        }

        return $this;
    }
    
    /**
     * @brief Generate the FROM part of the query.
     * @return String The FROM part of the query.
     */
    protected function generateFrom()
    {
        $from = '';
        
        foreach($this->from as $className)
        {
            $from .= $this->addClass($className).', ';
        }

        if($from == '')
        {
            return '';
        }

        return ' FROM '.substr($from, 0, -2);
    }
}

?>