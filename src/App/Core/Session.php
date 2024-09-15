<?php


/**
 * Description of Session
 *
 */
class Session {
    //put your code here
    
    static public function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
         }
    }
    
    static public function params(){
        return $_SESSION;
    }
    
    static public function get($name){
        return $_SESSION[$name];
    }
    
    static public function set($name, $value){
        return $_SESSION[$name] = $value;
    }
    
    static public function del($name){
        unset($_SESSION[$name]);
    }
}
