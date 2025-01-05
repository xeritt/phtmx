<?php


/**
 * Description of UserController
 *
 */
class UserController extends BaseController{
    
    public function __construct() {
        parent::__construct();
        $this->setTitle("Пользователи");
    }    
    
    public function newAction() {
        
        $item = $this->newItem();
        $arr = Model::getParamsPrivates($item, HTML::postParams());
        $arr["id"] = uniqid();
        $arr["password"] = Access::pass($arr["password"]); 
        $arr["passwordReply"] = Access::pass($arr["passwordReply"]); 
        $data  = new Data($this->getModelFileName());
        $ids = $data->readDataFile();
        $data->add($arr);
        $data->saveDataFile();
        
        //IndexController::indexAction();
        $this->indexAction();
    }
    
    public function getRules() {
        return [
          //"user" => ['index', 'new'],
          "admin" => ['index', 'main','new', 'edit', 'add', 'update', 'edit', 'del']
        ];
    }
}
