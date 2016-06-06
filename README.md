# ![Logo Pandore](https://raw.githubusercontent.com/Aldrien-/Pandore/master/Kernel/Plugins/ExceptionsHandler/Resources/pandore.png "Logo Pandore") Mercure

Mercure is an Object-Relational Mapping (ORM) library distributed with Pandore to easily abstract database queries.

## How to install

Put Mercure in your `Project/DataSources/` folder and add the following instructions into your Pandore configuration file (found in `Project/Config/`) under `[Datasource]`.

    source[__SourceName__] = Mercure
    dsn[__SourceName__] = dbms:__DBMS__+host:__HOST__+dbname:__DB_NAME__+username:__USERNAME__+password:__PASSWORD__

## How to use

As a data source, Mercure is automatically configured to make a connection between Pandore models and stored data as long as you use the right syntax to name your classes and database tables. Of course, you're free to use your own syntax to link classes and tables using your own object parser. Otherwise, you can use the default Mercure object parser whose syntax is based on `CamelCase` for name of classes and on `snake_case` for name of tables.

Mercure allows you to manipulate your stored data through a secure and friendly way. Mercure lets you focus on what matters to you and not SQL syntax or queries data control.

With the same idea of simplicity, CRUD operations of Pandore models work without any additionnal code (see `insertOne`, `selectOne`, `updateOne` and `deleteOne`). More complex use cases are described below.

### Select

#### Examples

Select all objects from the `class_name` table and return an array of `ClassName` objects.

    $objects = DataSourceProxy::get()->select('*')
                                     ->from('ClassName')
                                     ->getObjects('Namespace\\ClassName');

Select one object from the `class_name` table only filled by `class_name_attribute` and `class_name_another_attribute` where `class_name_id` is equal to `$id` and return the object.

    $oneObject = DataSourceProxy::get()->select('Attribute', 'AnotherAttribute')
                                       ->from('ClassName')
                                       ->where('id = ?', $id)
                                       ->getOneObject('Namespace\\Classname');

Select all objects from the `class_name` table only filled by `class_name_attribute` and `class_name_another_attribute`. and return an array of `ClassName` objects.

    $objects = DataSourceProxy::get()->select(array('Attribute', 'AnotherAttribute'))
                                     ->from('ClassName')
                                     ->getObjects('Namespace\\ClassName');

Count the number of rows which match a criteria (if specified).

    $res = DataSourceProxy::get()->select('COUNT(*) AS count')
                                 ->from('TableTest')
                                 ->getOneResult(\PDO::FETCH_OBJ);

Use `$res->count` to get the number of rows.

    echo('Number of rows : '.$res->count);
    =>
    Number of rows : 2

#### Results presentation

Select queries are the only ones which directly return database data. That's why, Mercure provides several ways to get data depending on which format you need to get results.

##### The getResults method

###### Prototype

     /**
      * @brief Execute a query and return results.
      * @param Int $fetchStyle Controls how the next row will be returned.
      * @return Mixed The query result.
      */
    public function getResults($fetchStyle = \PDO::FETCH_ASSOC)

###### Example

    $results = DataSourceProxy::get()->select('*')
                                     ->from('ClassName')
                                     ->getResults();

###### Results print

    Array
    (
        [0] => Array
            (
                [id] => 1
                [attribute] => 47654.3
                [anotherAttribute] => first example
            )

        [1] => Array
            (
                [id] => 2
                [attribute] => 13.23
                [anotherAttribute] => second example
            )

    )

##### The getOneResult method

###### Prototype

     /**
      * @brief Execute a query and return one result.
      * @param Int $fetchStyle Controls how the next row will be returned.
      * @return Mixed The query result.
      *
      * @exception Kernel::Exceptions::BadCountException When the query has returned an invalid result quantity.
      */
    public function getOneResult($fetchStyle = \PDO::FETCH_ASSOC)

###### Example

    $result = DataSourceProxy::get()->select('*')
                                    ->from('ClassName')
                                    ->where('id = ?', $id)
                                    ->getOneResult();

###### Result print

    Array
    (
        [id] => 1
        [attribute] => 47654.3
        [anotherAttribute] => first example
    )

##### The getObjects method

###### Prototype

     /**
      * @brief Execute a query and return an array of object.
      * @param String $objectType The complete object name (with namespace).
      * @param String $index The name of the attribute used as index of the result array.
      * @return Array The object array.
      */
     public function getObjects($objectType, $index = NULL)

###### Example

     $objects = DataSourceProxy::get()->select('*')
                                      ->from('ClassName')
                                      ->getObjects('Namespace\\ClassName', 'id');

###### Results print

    Array
    (
        [0] => Project\Models\ClassName Object
            (
                [id:Project\Models\ClassName:private] => 1
                [attribute:Project\Models\ClassName:private] => 47654.3
                [anotherAttribute:Project\Models\ClassName:private] => first example
            )

        [1] => Project\Models\ClassName Object
            (
                [id:Project\Models\ClassName:private] => 2
                [attribute:Project\Models\ClassName:private] => 13.23
                [anotherAttribute:Project\Models\ClassName:private] => second example
            )
    )

##### The getOneObject method

###### Prototype

     /**
      * @brief Execute a query and return ONE object.
      * @param string $objectType The complete object name (with namespace).
      * @return Mixed The object.
      *
      * @exception Kernel::Exceptions::BadCountException When the query has returned an invalid object quantity.
      */
    public function getOneObject($objectType)

###### Example

    $object = DataSourceProxy::get()->select('attribute', 'anotherAttribute')
                                    ->from('ClassName')
                                    ->where('id = ?', $id)
                                    ->getOneObject('Namespace\\ClassName');

###### Result print

    Project\Models\ClassName Object
    (
        [id:Project\Models\ClassName:private] => 
        [attribute:Project\Models\ClassName:private] => 47654.3
        [anotherAttribute:Project\Models\ClassName:private] => first example
    )

### Update

#### Examples    

Update `class_name` rows by setting its `class_name_attribute` to `newValue` where `class_name_id` equals to `$id`.

    DataSourceProxy::get()->update('ClassName')
                          ->set('attribute', $newValue)
                          ->where('id = ?', $id)
                          ->exec();

Mercure handles complex cases in `SET` clause. In this example, 3 is added to all `class_name_attribute` values wihch match a complex `WHERE` clause..

    DataSourceProxy::get()->update('ClassName', 'AnotherClassName')
                          ->set('ClassName.attribute', 3, 'ClassName.attribute + ?')
                          ->where('ClassName.id = AnotherClassName.id')
                          ->andWhere('AnotherClassName.id = ?', array($id))
                          ->exec();

#### Result

`Update` queries return `true` on success or `false` if an error has occured.

### Insert

#### Examples

Insert a row into the `class_name` table and only fill some specific columns.

    DataSourceProxy::get()->insertInto('ClassName', 'Attribute', 'AnotherAttribute')
                          ->values($value, $anotherValue)
                          ->exec();

Insert a row into the `class_name` table and apply a SQL function on a value.

    DataSourceProxy::get()->insertInto('ClassName')
                          ->values(array('ROUND(?)', $value), $anotherValue)
                          ->exec();

Insert a row into the `class_name` table using an array of values.

    DataSourceProxy::get()->insertInto('ClassName')
                          ->values(array($value, $anotherValue))
                          ->exec();

#### Result

`InsertInto` queries return `true` on success or `false` if an error has occured.

### Delete

#### Example

Remove rows which match the `WHERE` clause from the `class_name` table.

    DataSourceProxy::get()->deleteFrom('ClassName')
                          ->where('id = ?', $id)
                          ->exec();

#### Result

`DeleteFrom` queries return `true` on success or `false` if an error has occured.

### Others instructions

Each kind of query can be upgraded with some classic SQL clauses :

#### Limit

##### Prototype

    /**
     * @brief Add a LIMIT clause to the query.
     * @param Int $nb The number of needed results.
     * @param Int $skip The number of skipped element.
     * @return Mixed The query.
     */
    public function limit($nb, $skip = 0)

##### Example

    $res = DataSourceProxy::get()->select('*')
                                 ->from('ClassName')
                                 ->limit(5)
                                 ->getResults();

#### Join

Mercure allows to manipulate different kind of join :

  - crossJoin
  - innerJoin
  - join
  - leftJoin
  - leftOuterJoin
  - naturalLeftJoin
  - naturalLeftOuterJoin
  - naturalRightJoin
  - naturalRightOuterJoin
  - rightJoin
  - rightOuterJoin
  - straightJoin

and different kind of join predicate :

##### on
        
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

##### orOn

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

##### andOn

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

##### using

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

##### Example

    $res = DataSourceProxy::get()->select('*')
                                 ->from('ClassName')
                                 ->join('AnotherClassName')
                                 ->on('ClassName.id = AnotherClassName.id')
                                 ->getResults();

#### OrderBy

##### Prototype

###### order by asc

    /** 
     * @brief Add an ORDER BY ASC clause to the query.
     * @param $attribute The attribute.
     * @return Mixed The query.
     */
    public function orderByAsc($attribute)

###### order by desc

    /** 
     * @brief Add an ORDER BY DESC clause to the query.
     * @param $attribute The attribute.
     * @return Mixed The query.
     */
    public function orderByDesc($attribute)

##### Example

    $res = DataSourceProxy::get()->select('attribute', 'anotherAttribute')
                                 ->from('ClassName')
                                 ->orderByDesc('attribute')
                                 ->getResults();

#### Where

##### Examples

    $res = DataSourceProxy::get()->select('*')
                                 ->from('ClassName')
                                 ->where('id = ?', $id)
                                 ->andWhere('attribute < ?', 10)
                                 ->orWhere('anotherAttribute > ?', 5)
                                 ->getResults();

`WHERE` clauses allow you to write conditions as complex as you want in one time such as a complex condition with a lot of brackets :

    $res = DataSourceProxy::get()->select('*')
                                 ->from('ClassName')
                                 ->where('id = ? OR (attribute < ? AND attribute > ?)', array($id, 5, 10))
                                 ->getResults(); 
    
## Special thanks

**Jolan Teinturier**

For his huge contribution.

## License

Copyright 2011-2013 [Alexandre Lemire](https://github.com/Aldrien-) & [Yannick Cladière](https://github.com/Yannz)

Licensed under the MIT license.