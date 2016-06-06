<?php

namespace Project\DataSources\Mercure\QueryClause;

/**
 * @brief The SET clause of the query.
 */
trait SetClause
{
	use Clause;
	
    /**
     * @brief The SET string.
     * @var String.
     */
    protected $set = '';
    
    /**
     * @brief Add a SET clause to the query.
     * @param String $attribute The attribute name.
     * @param Mixed $queryData The query data.
     * @param String $rule The SET rule formatted to be compliant with PDO.
	 * @return Mixed The query.
     *
     * @details
     * The query data can only be a simple value or an array.
     *
     * @details
     * Use :
     * - set('name', 'newName')
     * - set('value', 2, 'value * ?')
     */
    public function set($attribute, $queryData, $rule = '?')
    {
		$this->set .= $attribute .' = '.$rule.', ';
		$this->addArgument($queryData);

        return $this;
	}
	
	/**
     * @brief Generate the SET part of the query.
     * @return String The SET part of the query
     */
    protected function generateSet()
    {
        if($this->set == '')
        {
            return '';
        }

		return ' SET '.$this->getFieldName(substr($this->set, 0, -2));
	}
}

?>