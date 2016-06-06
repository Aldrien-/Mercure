<?php

namespace Project\DataSources\Mercure\QueryClause;

/**
 * @brief The ORDER BY clause of the query.
 */
trait OrderByClause
{
    use Clause;
	
    /**
     * @brief The ORDER BY string.
     * @var String.
     */
	protected $orderBy = '';
    
    /** 
     * @brief Add an ORDER BY ASC clause to the query.
     * @param $attribute The attribute.
	 * @return Mixed The query.
     */
    public function orderByAsc($attribute)
    {
		$this->orderBy .= $attribute.' ASC, ';
        return $this;
    }
	
    /** 
     * @brief Add an ORDER BY DESC clause to the query.
     * @param $attribute The attribute.
     * @return Mixed The query.
     */
	public function orderByDesc($attribute)
    {
		$this->orderBy .= $attribute.' DESC, ';
        return $this;
    }
	
	/**
     * @brief Generate the ORDER BY part of the query.
     * @return String The ORDER BY part of the query
     */
    protected function generateOrderBy()
    {
        if($this->orderBy == '')
        {
            return '';
        }
        
		return ' ORDER BY '.substr($this->getFieldName($this->orderBy), 0, -2);
	}
}

?>