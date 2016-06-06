<?php

namespace Project\DataSources\Mercure\QueryClause;

/**
 * @brief The LIMIT clause of the query.
 */
trait LimitClause
{
	use Clause;

    /**
     * @brief The LIMIT string.
     * @var String.
     */
    protected $limit = '';
    
    /**
     * @brief Add a LIMIT clause to the query.
     * @param Int $nb The number of needed results.
     * @param Int $skip The number of skipped element.
     * @return Mixed The query.
     */
    public function limit($nb, $skip = 0)
    {
        if($skip == 0)
		{
            $this->limit .= intval($nb);
		}
        else
        {
            $this->limit .= intval($skip).', '.intval($nb);
        }

		return $this;
    }
	
	/**
     * @brief Generate the LIMIT part of the query.
     * @return String The LIMIT part of the query.
     */
    protected function generateLimit()
    {
        if($this->limit == '')
        {
            return '';
        }
        
		return ' LIMIT '.$this->limit;
	}
}

?>