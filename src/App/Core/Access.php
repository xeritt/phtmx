<?php

/**
 * Description of Access
 *
 */
class Access {
    
    static private string $islogin;
    static private string $rulesModel = 'Rules';

    static public function pass($password) {
        return md5($password);
    }
    
    static public function logout($login) {
        //session_start();
        Session::start();
        $islogin = Session::get("islogin");
        if ($islogin == 1){
            Session::del("islogin");
            if (isset(self::$islogin)) unset(self::$islogin);
            echo "Ok;";
            return true;
        }
        return false;
    }
    
    static public function ifLogin() {
        //session_start();
        Session::start();
        $params = Session::params();
        if (isset($params["islogin"]) && $params["islogin"] == 1){
            return true;
        }
        return false;
    }
    
    static public function login($login) {
        //session_start();
        Session::start();
        $params = Session::params();
        
        if (!isset(self::$islogin) && $params["islogin"] != 1){
            self::$islogin = 1;
            //$params = HTML::sessionParams();
            Session::set('islogin', 1);
            Session::set('login', $login);
            //$params["login"] = 1;
            return true;
        } else if ($params["islogin"] == 1){
            return true;
        }
        return false;
    }
    
    static public function printSession() {
        //session_start();
        Session::start();
        $params = Session::params();
        print_r($params);
        echo "!!!";
    }

    static public function checkController() {
        $controllerName = Url::getController();
        $action = Url::getAction();
        
        $controller = new $controllerName();    
        $access = $controller->getRules();
        if (Access::ifLogin()){
            $login = Session::get('login');
            if (isset($access[$login])){
                $actions = $access[$login];
                if (in_array($action, $actions)){
                    return true;
                }
            } 
        }
        return false;
    }
    
    static public function checkRulesModel() {
        $controllerName = Url::getController();
        $action = Url::getAction();
        
        $data  = new Data(self::$rulesModel.".json");
        $ids = $data->readDataFile();
        $controllerCount = 0;
        $login = Session::get('login');
        foreach ($ids["data"] as $key => $rule) {
            $controllerRule = $rule["controller"]."Controller";
            //echo $rule["login"].'['.$rule["actions"].']('.$controllerRule.") ";
            
            if ($rule["login"] == $login && $controllerRule == $controllerName){
                //echo "contr=".$controllerName."|||";
                $controllerCount++;
                $actions = $rule["actions"];
                $pos = strpos($actions, $action);
                if ($pos === false) {
                    //echo "action===".$action;
                } else {
                    return true;
                }
            }

        }
        if ($controllerCount == 0) return true; //Нет правил
        return false;
        
    }
    
    static public function check() {
        $modelName = Url::getModel();
        $controllerName = Url::getController();
        $action = Url::getAction();
        
        if ((method_exists($controllerName, "getRules"))){
            //echo "Check controller";
            return self::checkController();
        } else {
            if (Access::ifLogin()){
                //echo "Check Rules Model";
                return self::checkRulesModel();
            } else{
                $data  = new Data(self::$rulesModel.".json");
                $ids = $data->readDataFile();
                $controllerCount = 0;
                $login = Session::get('login');
                foreach ($ids["data"] as $key => $rule) {
                    //echo $rule["login"];
                    $controllerRule = $rule["controller"]."Controller";
                    if ($controllerRule == $controllerName){
                        $controllerCount++;
                    }    
                }
                if ($controllerCount == 0) return true; //Нет правил
                return false;
            }
            
        }
        return true;
    }
}
