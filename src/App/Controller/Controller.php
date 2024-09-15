<?php

/**
 * Description of Controller
 *
 */
class Controller {
    //put your code here
    public function getModelFileName() {
        return $this->getModelName().'.json';
    }
    
    public function getModelName() {
        return Url::getModel();
    }
    
    public function newItem() {
        $name = $this->getModelName();
        return new $name; //Config::$modelName();
    }    
}
