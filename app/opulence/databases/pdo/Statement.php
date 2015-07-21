<?php
/**
 * Copyright (C) 2015 David Young
 *
 * Defines an extension of PDOStatement
 */
namespace Opulence\Databases\PDO;
use PDO;
use PDOStatement;
use Opulence\Databases\IStatement;

class Statement extends PDOStatement implements IStatement
{
    /**
     * We need this because PDO is expecting a private/protected constructor in PDOStatement
     */
    protected function __construct()
    {
        // Don't do anything
    }

    /**
     * @inheritdoc
     */
    public function bindParam($parameter, &$variable, $dataType = PDO::PARAM_STR, $length = null, $driverOptions = null)
    {
        return parent::bindParam($parameter, $variable, $dataType, $length, $driverOptions);
    }

    /**
     * @inheritdoc
     */
    public function bindValue($parameter, $value, $dataType = PDO::PARAM_STR)
    {
        return parent::bindValue($parameter, $value, $dataType);
    }

    /**
     * Binds a list of values to the statement
     *
     * @param array $values The mapping of parameter name to a value or to an array
     *      If mapping to an array, the first item should be the value and the second should be the data type constant
     * @return bool True if successful, otherwise false
     */
    public function bindValues(array $values)
    {
        $isAssociativeArray = (bool)count(array_filter(array_keys($values), "is_string"));

        foreach($values as $parameterName => $value)
        {
            if(!is_array($value))
            {
                $value = [$value, PDO::PARAM_STR];
            }

            // If this is an indexed array, we need to offset the parameter name by 1 because it's 1-indexed
            if(!$isAssociativeArray)
            {
                $parameterName += 1;
            }

            if(count($value) != 2 || !$this->bindValue($parameterName, $value[0], $value[1]))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function execute($parameters = null)
    {
        return parent::execute($parameters);
    }

    /**
     * @inheritdoc
     */
    public function fetch($fetchStyle = PDO::ATTR_DEFAULT_FETCH_MODE, $cursorOrientation = null, $cursorOffset = null)
    {
        if($fetchStyle === null && $cursorOrientation === null && $cursorOffset === null)
        {
            return parent::fetch();
        }

        if($cursorOrientation === null && $cursorOffset === null)
        {
            return parent::fetch($fetchStyle);
        }

        if($cursorOffset === null)
        {
            return parent::fetch($fetchStyle, $cursorOrientation);
        }

        return parent::fetch($fetchStyle, $cursorOrientation, $cursorOffset);
    }

    /**
     * @inheritdoc
     */
    public function fetchAll($fetchStyle = PDO::ATTR_DEFAULT_FETCH_MODE, $fetchArgument = null, $ctorArgs = null)
    {
        if($fetchStyle === null && $fetchArgument === null && $ctorArgs === null)
        {
            return parent::fetchAll();
        }

        if($fetchArgument === null && $ctorArgs === null)
        {
            return parent::fetchAll($fetchStyle);
        }

        if($ctorArgs === null)
        {
            return parent::fetchAll($fetchStyle, $fetchArgument);
        }

        return parent::fetchAll($fetchStyle, $fetchArgument, $ctorArgs);
    }

    /**
     * @inheritdoc
     */
    public function fetchColumn($columnNumber = 0)
    {
        return parent::fetchColumn($columnNumber);
    }

    /**
     * @inheritdoc
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        if($arg2 === null && $arg3 === null)
        {
            return parent::setFetchMode($fetchMode);
        }

        if($arg3 === null)
        {
            return parent::setFetchMode($fetchMode, $arg2);
        }

        return parent::setFetchMode($fetchMode, $arg2, $arg3);
    }
} 