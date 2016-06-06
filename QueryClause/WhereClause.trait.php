<?php

namespace Project\DataSources\Mercure\QueryClause;

/**
 * @brief The WHERE clause of the query.
 */
trait WhereClause
{
	use Clause;
	
    /**
     * @brief The WHERE string.
     * @var String.
     */
	protected $where = '';
	
    /**
     * @brief Add a WHERE clause to the query.
     * @param String $condition The WHERE condition.
     * @param Mixed $queryData The query data.
     * @return Mixed The query.
     *
     * @details
     * The query data can only be a simple value or an array.
     */
    public function where($condition, $queryData = null)
    {
        $this->where .= $condition;

		if($queryData !== null)
        {
			$this->addArgument($queryData);
        }
        
        return $this;
    }

    /**
     * @brief Add a AND condition to the query.
     * @param String $condition The WHERE condition.
     * @param Mixed $queryData The query data.
     * @return Mixed The query.
     *
     * @details
     * The query data can only be a simple value or an array.
     */
    public function andWhere($condition, $queryData = null)
    {
        return $this->where(' AND '.$condition, $queryData);
    }

    /**
     * @brief Add a OR condition to the query.
     * @param String $condition The WHERE condition.
     * @param Mixed $queryData The query data.
     * @return Mixed The query.
     *
     * @details
     * The query data can only be a simple value or an array.
     */
    public function orWhere($condition, $queryData = null)
    {
        return $this->where(' OR '.$condition, $queryData);
    }
	
	/**
     * @brief Generate the WHERE part of the query.
     * @return String The WHERE part of the query.
     */
    protected function generateWhere()
    {
		if($this->where == '')
		{
			return '';
		}

		if(strpos($this->where, ' AND ') === 0)
		{
			$this->where = substr($this->where, 5);
		}
		elseif(strpos($this->where, ' OR ') === 0)
		{
			$this->where = substr($this->where, 4);
		}
        
		return ' WHERE '.$this->getFieldName($this->where);
	}
}

?>