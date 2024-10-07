<?php


/**
 *
 */
class View {
    
    function render($view_path, $params){
        $path  = '../'.Config::$view_path;
        $path .= $view_path.'.php';
        return $this->get($path, $params);
    }
    
    function renderLayout($layout_path, $params){
        $path  = '../'.Config::$layout_path;
        $path .= $layout_path.'.php';
        return $this->get($path, $params);
    }
    
    function get($path, $params) {
        //$layout_path = '../'.Config::$layout_path.$path.'.php';
        //echo $layout_path;
        //echo __DIR__;
        extract($params);
        ob_start();              // start output buffer 1
        require_once $path;
        $out = ob_get_clean();
        return $out;
        //return $layout_path;
    }
    
}
