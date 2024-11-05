<?php

//namespace App\Core;
/**
 * Description of CSS
 *
 */
class CSS {
    
    static private $loadedStyles = []; //Блоки стилей(страрый)
    static private $loadedClasses = []; //Регаются классы
    
    static public function isLoad($name) {
        return in_array($name, array_keys(self::$loadedStyles));
    }
    
    static public function load($name, $style) {
        
        if (self::isLoad($name)) return '';
        self::$loadedStyles[$name] = $style;
        return $style;
    }
    
    public static function getLoadedStyles() {
        return self::$loadedStyles;
    }
    
    /**Добавляет класс 
     * 
     * @param type $name
     * @param type $body
     * @return type
     */
    public static function add($name, $body) {
        
        if (in_array($name, array_keys(self::$loadedClasses))) return;
        echo $name.$body;
        self::$loadedClasses[$name] = $body;    
    }
    
    public static function getAllClasses($br = '\n') {
        $css = '<style>';
        foreach (self::$loadedClasses as $name => $body) {
            
            $css .= $name .'{'.$br;
            $css .= $body .'}'.$br;
        }
        $css .= '</style>';
        return $css;
    }
    
}
