<?php

namespace Project\DataSources\Mercure\QueryClause;

/**
 * @brief The JOIN clause of the query.
 */
trait JoinClause
{
    use Clause;
    
    /**
     * @brief The JOIN array.
     * @var Array.
     */
    protected $join = array();

    /**
     * @brief Add a CROSS JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function crossJoin($className)
    {
        return $this->addJoin('CROSS JOIN', $className);
    }
    
    /**
     * @brief Add a INNER JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function innerJoin($className)
    {
        return $this->addJoin('INNER JOIN', $className);
    }

    /**
     * @brief Add a JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function join($className)
    {
        return $this->addJoin('JOIN', $className);
    }

    /**
     * @brief Add a LEFT JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function leftJoin($className)
    {
        return $this->addJoin('LEFT JOIN', $className);
    }
    
    /**
     * @brief Add a LEFT OUTER JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function leftOuterJoin($className)
    {
        return $this->addJoin('LEFT OUTER JOIN', $className);
    }

    /**
     * @brief Add a NATURAL LEFT JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function naturalLeftJoin($className)
    {
        return $this->addJoin('NATURAL LEFT JOIN', $className);
    }
    
    /**
     * @brief Add a NATURAL LEFT OUTER JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function naturalLeftOuterJoin($className)
    {
        return $this->addJoin('NATURAL LEFT OUTER JOIN', $className);
    }
    
    /**
     * @brief Add a NATURAL RIGHT JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function naturalRightJoin($className)
    {
        return $this->addJoin('NATURAL RIGHT JOIN', $className);
    }
    
    /**
     * @brief Add a NATURAL RIGHT OUTER JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function naturalRightOuterJoin($className)
    {
        return $this->addJoin('NATURAL RIGHT OUTER JOIN', $className);
    }

    /**
     * @brief Add a RIGHT JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function rightJoin($className)
    {
        return $this->addJoin('RIGHT JOIN', $className);
    }
    
    /**
     * @brief Add a RIGHT OUTER JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function rightOuterJoin($className)
    {
        return $this->addJoin('RIGHT OUTER JOIN', $className);
    }
    
    /**
     * @brief Add a STRAIGHT JOIN clause to the query.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    public function straightJoin($className)
    {
        return $this->addJoin('STRAIGHT_JOIN', $className);
    }
        
    /**
     * @brief Add a ON condition to the query.
     * @param String $condition The JOIN condition.
     * @param Mixed $queryData The query data.
	 * @return Mixed The query.
     *
     * @details
     * The query data can only be a simple value or an array.
     */
    public function on($condition, $queryData = null)
    {
		return $this->addOn('ON', $condition, $queryData);
    }
    
    /**
     * @brief Add a OR ON condition to the query.
     * @param String $condition The JOIN condition.
     * @param Mixed $queryData The query data.
     * @return Mixed The query.
     *
     * @details
     * The query data can only be a simple value or an array.
     */
    public function orOn($condition, $queryData = null)
    {
        return $this->addOn('OR', $condition, $queryData);
    }
    
    /**
     * @brief Add a AND ON condition to the query.
     * @param String $condition The JOIN condition.
     * @param Mixed $queryData The query data.
     * @return Mixed The query.
     *
     * @details
     * The query data can only be a simple value or an array
     */
    public function andOn($condition, $queryData = null)
    {
		return $this->addOn('AND', $condition, $queryData);
    }
    
    /**
     * @brief Add a USING to the query.
     * @param Mixed $attributes The restricted attributes of the natural JOIN clause.
     * @return Mixed The query.
     *
     * @details
     * Use :
     * - using('attr1', 'attr2')
     * - using(array('attr1', 'attr2'))
     */
    public function using($attributes)
    {
        if(!is_array($attributes))
        {
            $attributes = func_get_args();
        }

        $this->join[] = array('type' => 'USING', 'value' => '('.implode(', ', $attributes).')');
        
        return $this;
    }
    
    /**
     * @brief Generate the JOIN part of the query.
     * @return String The JOIN part of the query.
     */
    protected function generateJoin()
    {
        $join = '';

        foreach($this->join as $part)
        {
            if(stripos($part['type'], 'JOIN') !== false)
            {
                $join .= ' '.$part['type'].' '.$this->addClass($part['value']);
            }
            else
            {
                $join .= ' '.$part['type'].' '.$this->getFieldName($part['value']);
            }
        }

        return $join;
    }
    
    /**
     * @brief Add a JOIN clause to the query.
     * @param String $type The JOIN type.
     * @param String $className The class name.
     * @return Mixed The query.
     */
    private function addJoin($type, $className)
    {
        $this->join[] = array('type' => $type, 'value' =>$className);

        return $this;
    }

    /**
     * @brief Adds a JOIN condition to the query.
     * @param String $type The condition type.
     * @param String $condition The JOIN condition.
     * @param Mixed $queryData The query data.
     * @return Mixed The query.
     */
    private function addOn($type, $condition, $queryData = null)
    {
        $this->join[] = array('type' => $type, 'value' =>$condition);
        if($queryData !== null)
        {
            $this->addArgument($queryData);
        }
        return $this;
    }
}

?>