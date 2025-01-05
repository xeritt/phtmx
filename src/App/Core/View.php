<?php


/**
 *
 */
class View {
    
    function view_exists($view){
        $path  = '../'.Config::$view_path;
        $path .= $view.'.php';
        //echo "path:".$path.'??'.file_exists($path);
        return file_exists($path);
    }

    function layout_exists($layout){
        $path  = '../'.Config::$layout_path;
        $path .= $layout.'.php';
        return file_exists($path);
    }
    
    function render($view, $params){
        $path  = '../'.Config::$view_path;
        $path .= $view.'.php';
        return $this->get($path, $params);
    }
    
    function renderLayout($layout, $params){
        $path  = '../'.Config::$layout_path;
        $path .= $layout.'.php';
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
