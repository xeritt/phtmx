<?php

//namespace App\Core;
/**
 * Description of CSS
 *
 */
class CSS {
    static private $loadedStyles = [];
    
    static public function isLoad($name) {
        return in_array($name, array_keys(self::$loadedStyles));
    }
    
    static public function load($name, $style) {
        self::$loadedStyles[$name] = $style;
        return $style;
    }
    
    public static function getLoadedStyles() {
        return self::$loadedStyles;
    }

}
