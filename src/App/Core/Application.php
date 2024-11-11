<?php

/**
 * Description of Page
 *
 */
class Application {
    static private $controller;
    public static function getController() {
        return self::$controller;
    }

    public function __construct() {}

    public function getAction($params) {
        $name = Url::getActionName();
        return $params[$name] ?? null;
    }
    
    public function getPage($params) {
        $name = Url::getModelName();
        return $params[$name] ?? null;
    }
    
    public function getClassName() {
        return get_class($this);
    }

    public function run() {
        //$params = $this->getParams();
        $params = HTML::getParams();
        
        $action = $this->getAction($params);
        if ($action != "") $action .= 'Action';
        
        $className = $this->getPage($params);
        if ($className != "") $className .= 'Controller';
        
        $res = false;
        //echo $className.$action;
        if ($action != "" && $className != ""){
            if ((method_exists($className, $action))){
                if (!Access::check()) {
                    e::o(Config::getAccessDenidedMessage());
                    if (!Access::ifLogin()) echo HTML::link("login.html", "Login");
                    return;
                }
                
                $obj = new $className();
                self::$controller = &$obj;
                $res = $obj->$action();
            } else {
                e::o('No action '.$action.' in class '. $className);
            }
        } else if ($className != ""){
            if ((method_exists($className, $action))){
            //echo "3";
                $obj = new $className();
                self::$controller = &$obj;
                $res = $obj->indexAction();
            } else {
                e::o('No action '.$action.' in class '. $className);
            }    
        } else {                       
            //echo "2";
            $obj = new IndexController();
            self::$controller = &$obj;
            $res = $obj->indexAction();
        }
        
        if ($res != false) e::o($res);
    }
    
}
