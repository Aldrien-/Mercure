<?php

namespace Project\DataSources\Mercure\ObjectParser;

use Kernel\Services as Services;
use Project\DataSources\Mercure as Mercure;
use Project\DataSources\Mercure\Exceptions as Exceptions;

/**
 * @brief This class implements the factory pattern in order to build object parsers.
 *
 * @see Kernel::Services::IniParser.
 * @see Mercure;:Mercure.
 * @see Mercure::ObjectParser::IObjectParser.
 */
class ObjectParserFactory
{
    /**
     * @brief The object parser interface name.
     * @var String.
     */
    private static $dataSourceInterfaceName = 'Project\DataSources\Mercure\ObjectParser\IObjectParser';

    /**
     * @brief Build an object parser from its class name.
     * @param String $className The object parser class name.
     * @param Mercure::Mercure $mercure The Mercure object.
     * @param Kernel::Services::IniParser $config The Mercure configuration object.
     * @return Mercure::ObjectParser::IObjectParser The object parser.
     *
     * @exception Mercure::Exceptions::ObjectParserFactoryException When the desired class doesn't exist.
     * @exception Mercure::Exceptions::ObjectParserFactoryException When the desired class doesn't implement the object parser interface.
     * @exception Mercure::Exceptions::ObjectParserFactoryException When the object parser isn't instantiable.
     */
    public static function get($className, Mercure\Mercure $mercure, Services\IniParser $config)
    {
        try {
            // Create a reflection class from the object parser class.
            $reflectionClass = new \ReflectionClass($className);
        } catch(\Exception $e) {
            throw new Exceptions\ObjectParserFactoryException($objectParserName.' doesn\'t exist.');
        }
        
        // If the class doesn't implement the object parser interface.
        if(!$reflectionClass->isSubclassOf(self::$dataSourceInterfaceName))
        {
            throw new Exceptions\ObjectParserFactoryException($objectParserName.' doesn\'t implement the object parser interface.');
        }
        
        // If the class isn't instantiable.
        if(!$reflectionClass->isInstantiable())
        {
            throw new Exceptions\ObjectParserFactoryException($objectParserName.' isn\'t instantiable.');
        }
        
        return $reflectionClass->newInstance($mercure, $config);
    }
}

?>