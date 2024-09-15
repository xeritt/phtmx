<?php

/**
 * Description of HTML
 *
 */
class HTML {
    
    static public function legend($text) {
        $html = '<legend>';
        $html .= $text;
        $html .= '</legend>';
        return $html;
    }

    static public function getAttr($attrs) {
        $html = '';
        foreach ($attrs as $key => $value) {
            $html .= $key.'="'.$value.'" ';
        }
        return $html;
    }
    
    static public function tag($content, $tag = 'div', $attrs = []) {
        $attr = self::getAttr($attrs);
        $html = '<'.$tag.' '.$attr.'>';
        $html .= $content;
        $html .= '</'.$tag.'>';
        return $html;
    }
    
    static public function fieldset($content, $legend = '', $class = '') {
        $html = '';
        $html .= '<fieldset ';
        if ($class != ''){
            $html .= '"'.$class.'"';    
        } 
        
        $html .= ' >';
        if ($legend != ''){
            $html .= self::legend($legend);
        }        
        $html .= $content;
        $html .= '</fieldset>';
        return $html;//.'<fieldset'<div class="'.$class.'">'.$content.'</div>';
    }

    static public function div($class, $content) {
        return '<div class="'.$class.'">'.$content.'</div>';
    }
    
    static public function link($href, $title) {
        return '<a href="'.$href.'" title="'.$title.'">'.$title.'</a>';
    }
    
    static public function br() {
        return "<br />";
    }
    
    static public function getParams(){
        return $_GET;
    }
    
    static public function postParams(){
        return $_POST;
    }
    
    static public function post($name){
        return $_POST[$name];
    }
    
    static public function get($name){
        return $_GET[$name];
    }
    
    
}
