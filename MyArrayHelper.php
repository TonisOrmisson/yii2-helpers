<?php
namespace andmemasin\helpers;

use yii\base\InvalidArgumentException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


/**
 * my additions to yii's default arrayhelper
 *
 * @package app\models\helpers
 * @author Tonis Ormisson <tonis@andmemasin.eu>
 */
class MyArrayHelper extends ArrayHelper{

    /**
     * Take a non-indexed array and make an indexed array using the value 
     * as both index and value
     * @param array $array A NON-INDEXES single dimension array
     * @return array
     * @throws InvalidArgumentException
     */
    public static function selfIndex($array) {
        if(is_array($array)){
            $out = [];
            foreach ($array as $value) {
                $out[$value] = $value;
            }
            return $out;
        }else{
            throw new InvalidArgumentException(gettype($array).' used as array in '.__CLASS__.'::'.__FUNCTION__);
        }
        
    }


    /**
     * Re-index an array based on a map. Map holds the indexes we want to apply to array.
     * @param array $map
     * @param array $array
     * @return array
     */
    public static function mapIndex($map, $array){
        if(is_array($array)){
            $out = [];
            foreach ($map as $key => $value){
                $out[$value] = $array[$key];
            }
            return $out;
        }else{
            throw new InvalidArgumentException(gettype($array).' used as array in '.__CLASS__.'::'.__FUNCTION__);
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
    public static function indexByRow($array, $i = 0){
        $keys = $array[$i];
        if(is_array($array) && !empty($array)){
            $newArray= [];
            foreach ($array as $key=> $row) {
                // don'd add the indexing element into output
                if($key != $i){
                    $newRow = [];
                    $j = 0;
                    foreach ($row as $cell) {
                        $newRow[$keys[$j]] = $cell;
                        $j++;
                    }
                    $newArray[] = $newRow;
                }
            }
            
            return $newArray;
        }else{
            throw new InvalidArgumentException(gettype($array).' used as array in '.__CLASS__.'::'.__FUNCTION__);
        }

    }


    /**
     * Take an multi-dimensional array and re-index it by a value in each array element
     * @param array $array
     * @param string $colName
     * @return array
     */
    public static function indexByColumn($array, $colName){
        if(is_array($array)){
            if(!empty($array)){
                $newArray= [];
                foreach ($array as $key => $row) {
                    if($row instanceof ActiveRecord){
                        $rowArr = (array) $row->attributes;
                    }else if(is_array($row)){
                        $rowArr = $row;
                    }else{
                        throw new InvalidArgumentException('Only arrays or ActiveRecord Objects can be used in '.__CLASS__.'::'.__FUNCTION__);
                    }
                    // make it array if input is object

                    if(!isset($rowArr[$colName])){
                        throw new InvalidArgumentException('"'.$colName.'" missing as key in '.__CLASS__.'::'.__FUNCTION__);

                    }
                    $newArray[$rowArr[$colName]] = $row;
                }
                return $newArray;
            }
            // do nothing, empty array
            return $array;
        }else{
            throw new InvalidArgumentException(gettype($array).' used as array in '.__CLASS__.'::'.__FUNCTION__);
        }
    }
    
    /**
     * Remove element(s) from array based on their value 
     * @param array $array Haystack
     * @param mixed $removeValue value that we look for to delete
     * @return array
     */
    public static function removeByValue($array,$removeValue,$column = false) {
        foreach ($array as $key =>$value) {
            // if column is set then remove by specific column value
            if($column){

                if($value === $value[$column]){
                    unset($array[$key]);
                }
            }else{
                if($value === $removeValue){
                    unset($array[$key]);
                }
            }

        }
        return $array;
    }

    /**
     * Remove an ActiveRecord model from array of models by a value in one specified attribute
     * @param ActiveRecord[] $models
     * @param string $attribute
     * @param string $value
     * @return ActiveRecord[]
     */
    public static function removeModelByColumnValue($models, $attribute, $value){
        if(!empty($models)){
            foreach ($models as $key => $model){
                if($model->{$attribute} === $value){
                    unset($models[$key]);
                }
            }
        }
        return $models;
    }
}
