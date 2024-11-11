<?php

/**
 * Description of Url
 *
 */
class Url {
    static private $actionName = 'action';
    static private $modelName = 'model';
    /**
     * $form = new FormBuilder($book, "index.php?page=Book&action=new");
     * //$form = new FormBuilder($book, Url::get("index.php", "Book/new"));
     * //$form = new FormBuilder($book, Url::g("Book/new"));
     * 
     * @param type $param
     */
    static public function get($url, $controllerAndAction) {
        list($controller, $action) = explode('/', $controllerAndAction);
        //return $url.'?page='.$controller.'&action='.$action;
        return $url.'?'.self::$modelName.'='.$controller.'&'.self::$actionName.'='.$action;
    }
    
    /**
     * Формирует путь с параметрами
     * @param type $controllerAndAction Контроллер / действие
     * @param type $params
     * @return type
     */
    static public function go($controllerAndAction, $params = []) {
        list($controller, $action) = explode('/', $controllerAndAction);
        $paramsStr = '';
        foreach ($params as $key => $value) {
            $paramsStr .= '&'.$key.'='.$value;
        }
        //return 'index.php?page='.$controller.'&action='.$action.$paramsStr;
        return 'index.php?'.self::$modelName.'='.$controller.'&'.self::$actionName.'='.$action.$paramsStr;
    }

    static public function getAction() {
        return HTML::get(self::$actionName);
    }
    
    static public function getModel() {
        return HTML::get(self::$modelName);
    }
    
    static public function getController() {
        return self::getModel()."Controller";
    }
    
    public static function getActionName() {
        return self::$actionName;
    }

    public static function getModelName() {
        return self::$modelName;
    }

    public static function setActionName($actionName): void {
        self::$actionName = $actionName;
    }

    public static function setModelName($modelName): void {
        self::$modelName = $modelName;
    }


    
}
