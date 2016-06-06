<?php

namespace Project\DataSources\Mercure\ObjectParser;

use Kernel\Services as Services;
use Project\DataSources\Mercure\Mercure as Mercure;

/**
 * @brief The ObjectParser interface.
 * 
 * @details
 * This interface define minimal requirements to link classes and database tables.
 *
 * @see Kernel::Services::IniParser.
 * @see Mercure::Mercure.
 */
interface IObjectParser
{
    /**
     * @brief Constructor.
     * @param Mercure::Mercure $mercure The Mercure object.
     * @param Kernel::Services::IniParser $config The Mercure configuration object.
     */
    public function __construct(Mercure $mercure, Services\IniParser $config);
    
    /**
     * @brief Get all table fields.
     * @param String $className The classe name.
     * @return Array The array of field name.
     */
    public function getAllFields($className);

    /**
     * @brief Get an attribute from associated field and table.
     * @param String $fieldName The field name.
     * @param String $tableName The table name.
     * @return String The attribute name.
     */
    public function getAttribute($fieldName, $tableName);

    /**
     * @brief Get a value.
     * @param Mixed $object The object.
     * @param String $attribute The attribute name.
     * @return Mixed The value.
     */
    public function getAttributeValue($object, $attribute);

    /**
     * @brief Get attributes which are linked to auto incremented fields.
     * @param String $className The class name.
     * @return Array The attributes name array.
     */
    public function getAutoIncrement($className);

    /**
     * @brief Get the class name from the associated table name.
     * @param String $tableName The table name.
     * @return String The class name.
     */
    public function getClass($tableName);
    
    /**
     * @brief Get a field name from associated attribute name and class name.
     * @param String $attributeName The attribute name.
     * @param String $className The class name.
     * @return String The field name.
     */
    public function getField($attributeName, $className);

    /**
     * @brief Get attributes which are linked to primary keys.
     * @param String $className The class name.
     * @return Array The attributes name array.
     */
    public function getPrimaryKeys($className);

    /**
     * @brief Get the relative class name of an associated object.
     * @param Mixed $object The object.
     * @return String The relative class name.
     */
    public function getRelativeClassName($object);
    
    /**
     * @brief Get the table name of an associated class.
     * @param String $className The class name.
     * @return String The table name.
     */
    public function getTable($className);
        
    /**
     * @brief Set a value.
     * @param Mixed $object The object.
     * @param String $attribute The attribute name.
     * @param Mixed $value The value.
     */
    public function setAttributeValue(&$object, $attribute, $value);
}

?>