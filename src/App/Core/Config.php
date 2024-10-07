<?php

/**
 * Description of Config
 *
 */
class Config {
    //put your code here
    //static public $modelName = 'Book';
    //static public $modelName = 'Author';
    //хз может ненужно уже?
    static public $userName = 'User';
    
    static public function getAccessDenidedMessage(){
        return '<span style="color:red">Access denided</span>';
    }
    
    static private $entityManager;
    
    public static function getEntityManager() {
        return self::$entityManager;
    }

    public static function setEntityManager($entityManager): void {
        self::$entityManager = $entityManager;
    }
    
    static public $layout_path = 'src/App/Layout/';
    static public $view_path = 'src/App/View/';
    
}
