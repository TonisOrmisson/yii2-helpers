<?php
namespace andmemasin\helpers;

use yii\base\Component;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


/**
 * my additions to yii's default arrayhelper
 *
 * @package app\models\helpers
 * @author Tonis Ormisson <tonis@andmemasin.eu>
 */
class MyArrayHelper extends ArrayHelper {

    /**
     * Take a non-indexed array and make an indexed array using the value 
     * as both index and value
     * @param array $array A NON-INDEXES single dimension array
     * @return array
     * @throws InvalidArgumentException
     */
    public static function selfIndex($array) {
        if (is_array($array)) {
            $out = [];
            foreach ($array as $value) {
                if (!is_int($value) && !is_string($value)) {
                    throw new InvalidArgumentException('Array values must be string or int in '.__CLASS__.'::'.__FUNCTION__);
                }
                $out[$value] = $value;
            }
            return $out;
        } else {
            throw new InvalidArgumentException(gettype($array).' used as array in '.__CLASS__.'::'.__FUNCTION__);
        }
        
    }


    /**
     * Re-index an array based on a map. Map holds the indexes we want to apply to array.
     * @param array $map
     * @param array $array
     * @return array
     */
    public static function mapIndex($map, $array) {
        if (is_array($map) && is_array($array)) {
            $out = [];
            foreach ($map as $key => $value) {
                if (!array_key_exists($key, $array)) {
                    throw new InvalidArgumentException('"'.$key.'" missing as key in '.__CLASS__.'::'.__FUNCTION__);
                }
                if (!is_int($value) && !is_string($value)) {
                    throw new InvalidArgumentException('Map values must be string or int in '.__CLASS__.'::'.__FUNCTION__);
                }
                $out[$value] = $array[$key];
            }
            return $out;
        } else {
            throw new InvalidArgumentException(gettype($map).' and '.gettype($array).' used as array in '.__CLASS__.'::'.__FUNCTION__);
        }


    }

    /**
     * Converts an non-indexed MULTIDIMENSIONAL array (such as data matrix from spreadsheet)
     * into an indexed array based on the $i-th element in the array. By default its the 
     * first [0] element (header row). The indexing element will be excluded from output
     * array
     * @param array $array
     * @param integer $i
     * @return array
     */
    public static function indexByRow(array $array, ?int $i = 0) {
        if (empty($array)) {
            throw new InvalidArgumentException('Empty array  used as array in '.__CLASS__.'::'.__FUNCTION__);
        }

        if ($i === null) {
            throw new InvalidArgumentException('Row index cannot be null in '.__CLASS__.'::'.__FUNCTION__);
        }

        if (!array_key_exists($i, $array)) {
            throw new InvalidArgumentException('Missing indexing row "'.$i.'" in '.__CLASS__.'::'.__FUNCTION__);
        }

        $keys = $array[$i];
        if (!is_array($keys)) {
            throw new InvalidArgumentException('Indexing row must be array in '.__CLASS__.'::'.__FUNCTION__);
        }

        $newArray = [];
        foreach ($array as $key=> $row) {
            // don'd add the indexing element into output
            if ($key != $i) {
                if (!is_array($row)) {
                    throw new InvalidArgumentException('Rows must be arrays in '.__CLASS__.'::'.__FUNCTION__);
                }
                $newRow = [];
                $j = 0;
                foreach ($row as $cell) {
                    if (!array_key_exists($j, $keys)) {
                        throw new InvalidArgumentException('Missing index "'.$j.'" in indexing row in '.__CLASS__.'::'.__FUNCTION__);
                    }
                    if (!is_int($keys[$j]) && !is_string($keys[$j])) {
                        throw new InvalidArgumentException('Indexing row values must be string or int in '.__CLASS__.'::'.__FUNCTION__);
                    }
                    $newRow[$keys[$j]] = $cell;
                    $j++;
                }
                $newArray[] = $newRow;
            }
        }

        return $newArray;

    }


    /**
     * Take an multi-dimensional array and re-index it by a value in each array element
     * @param array $array
     * @param string $colName
     * @return array
     */
    public static function indexByColumn($array, $colName) {
        if (is_array($array)) {
            if (!is_string($colName) && !is_int($colName)) {
                throw new InvalidArgumentException('Column name must be string or int in '.__CLASS__.'::'.__FUNCTION__);
            }
            if (!empty($array)) {
                $newArray = [];
                foreach ($array as $key => $row) {
                    if ($row instanceof Component) {
                        /** @var Model $row */
                        $rowArr = (array) $row->attributes;
                    } else if (is_array($row)) {
                        $rowArr = $row;
                    } else {
                        throw new InvalidArgumentException('Only arrays or yii Component objects can be used in '.__CLASS__.'::'.__FUNCTION__);
                    }
                    // make it array if input is object

                    if (!isset($rowArr[$colName])) {
                        throw new InvalidArgumentException('"'.$colName.'" missing as key in '.__CLASS__.'::'.__FUNCTION__);

                    }
                    if (!is_int($rowArr[$colName]) && !is_string($rowArr[$colName])) {
                        throw new InvalidArgumentException('"'.$colName.'" value must be string or int in '.__CLASS__.'::'.__FUNCTION__);
                    }
                    $newArray[$rowArr[$colName]] = $row;
                }
                return $newArray;
            }
            // do nothing, empty array
            return $array;
        } else {
            throw new InvalidArgumentException(gettype($array).' used as array in '.__CLASS__.'::'.__FUNCTION__);
        }
    }
    
    /**
     * Remove element(s) from array based on their value 
     * @param array $array Haystack
     * @param mixed $removeValue value that we look for to delete
     * @return array
     */
    public static function removeByValue($array, $removeValue) {
        if (!is_array($array)) {
            throw new InvalidArgumentException(gettype($array).' used as array in '.__CLASS__.'::'.__FUNCTION__);
        }
        foreach ($array as $key =>$value) {
            if ($value === $removeValue) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Remove an Object from array of Objects by a value in one specified attribute
     * @param Component[] $models
     * @param string $attribute
     * @param string $value
     * @return Component[]
     */
    public static function removeModelByColumnValue($models, $attribute, $value) {
        if (!is_array($models)) {
            throw new InvalidArgumentException(gettype($models).' used as array in '.__CLASS__.'::'.__FUNCTION__);
        }

        if (!empty($models)) {
            foreach ($models as $key => $model) {
                if ($model->{$attribute} === $value) {
                    unset($models[$key]);
                }
            }
        }
        return $models;
    }
}
