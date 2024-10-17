<?php


class DoctrineController extends BaseController{
    public function __construct() {
        $this->isDoctrine = true;
    }
    
    public function getTable() {
        $html = '';
        $modelName = $this->getModelName();
        $entityManager = Config::getEntityManager();
        $productRepository = $entityManager->getRepository($modelName);
        $products = $productRepository->findAll();
        
        $table = new DoctrineTable($products);
        //$modelName = $this->getModelName();
        $table->setModelName($modelName);
        $html .= $table->getHTML();
        
        return $html;
    }
    
    public function getItems() {
        $html = '';
        $modelName = $this->getModelName();
        $html .= $this->getTable();
        //$html .= $table->getColTableHTML();

        $add = new Button("+ ".$modelName, "myDialog", Url::go($modelName."/add"), "loadDialog");
        $html .= $add->getHTML();
        
        $html .= HTML::br();
        $html .= HTML::br();
        return $html;
    }
    
    public function modelValueAction() {
        //return 'Ok';
        if (!Access::ifLogin()) { 
            return HTML::link("login.html", "Login");
        }    
        $type = $this->getModelName();//HTML::get('type');
        $id = HTML::get('id');
        $fieldName = HTML::get('fieldName');
        
        $obj = Model::loadDoctrineModelById($type, $id);
        $getter = 'get'.ucfirst($fieldName);
        $val = $obj->$getter();
        return $val;
    }

}
