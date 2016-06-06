<?php

namespace Project\DataSources\Mercure\QueryClause;

/**
 * @brief This trait imposes requirements upon the exhibiting class.
 */
trait Clause
{
    /**
     * @brief Add an attribute to the query.
     * @param String $attribute The attribute name.
     * @return String The field name.
     */
    protected abstract function addAttribute($attribute);

    /**
     * @brief Add an arguments to the query.
     * @param Mixed $arg The query data.
     */
    protected abstract function addArgument($arg);

    /**
     * @brief Add a class to the query.
     * @param String $class The class name.
     * @return String The table name.
     */
    protected abstract function addClass($class);

    /**
     * @brief Get the field name from associated attribute and class name.
     * @param String $attribute The attribute name.
     * @param Mixed $className The class name.
     * @return String The formated field name.
     */
    protected abstract function getFieldName($attribute, $className = null);
}

?>