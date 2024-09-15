<?php

/**
 * Description of Php
 *
 */
class Php {
    
    static public function getTypes(){
        return [
            "boolean",
            "int",
            "integer",
            "double",
            "float",
            "string",
            "array",
            "object",
            "resource",
            "NULL",
            "unknown type"
        ];
    }
    
    static public function inTypes($name){
        return in_array($name, self::getTypes());
    }
    /*
    static public function create($name) {
        $str = '$item = new '.$name.'();';
        eval($str);
        return $item;
    }*/
    
}
