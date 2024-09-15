<?php

/**
 * Description of BaseController
 *
 */
class BaseController {
    
    //public $modelName = 'Book';
    
    public function getModelName() {
        return Url::getModel();
    }
    
    public function getModelFileName() {
        return $this->getModelName().'.json';
    }
    
    public function newItem() {
        $name = $this->getModelName();
        return Model::create($name);//new $name(); //Config::$modelName();
    }
    
    public function addAction() {
        $item = $this->newItem();
        //$item = Model::class //$this->newItem();
        //$form = new FormBuilder($book, "Book/new");
        //var_dump($item);
        //exit();
        $form = new FormBuilder($item, Url::go($this->getModelName()."/new"));//"index.php?page=Book&action=new");
        e::o ($form->getForm());
        $submit = $form->getSubmit("Добавить");
        $submit->setDialogclose('myDialog');
        e::o ($submit->getHTML());
        $close = new Button("Закрыть", "myDialog", "index.php", "actionClose");
        e::o ($close->getHTML());
    }
    
    public function newAction() {
        
        $item = $this->newItem();
        $arr = Model::getParamsPrivates($item, HTML::postParams());
        $arr["id"] = uniqid();
        $data  = new Data($this->getModelFileName());
        $ids = $data->readDataFile();
        $data->add($arr);
        $data->saveDataFile();
        
        //IndexController::indexAction();
        $this->indexAction();
    }

    public function getTable() {
        $modelName = $this->getModelName();
        $data  = new Data($this->getModelFileName());
        $ids = $data->readDataFile();
        $table = new Table($ids["data"]);
        $table->setModelName($modelName);
        //$table->setStyle("color:red; border: 1px solid red;");
        $table->setClass("table");
        return $table;
        //$html .= $table->getColTableHTML();
    }
    
    public function getItems() {
        $html = '';
        $modelName = $this->getModelName();
        $table = $this->getTable();
        $html .= $table->getColTableHTML();
        /*
        $data  = new Data($this->getModelFileName());
        $ids = $data->readDataFile();
        $table = new Table($ids["data"]);
        $table->setModelName($modelName);
        //$table->setStyle("color:red; border: 1px solid red;");
        $table->setClass("table");
        $html .= $table->getColTableHTML();
         * 
         */
        //echo $table->getRowTableHTML();
        //print_r($ids);
        //echo HTML::br();

        //$add = new Button("Add", 'main', "load.php?page=Book&action=add");
        $add = new Button("+ ".$modelName, "myDialog", Url::go($modelName."/add"), "loadDialog");
        $html .= $add->getHTML();
        //echo HTML::br();
        //echo HTML::br();
        
        $html .= HTML::br();
        $html .= HTML::br();
        return $html;
    }
    
    public function indexAction() {
        //$modelName = $this->getModelName();//Config::$modelName;
        e::o ($this->getItems());
        //$edit = new Button("Edit", 'main', "load.php?page=Book&action=edit");
        //echo $edit->getHTML();
    }
    
    public function updateAction() {
        $data  = new Data($this->getModelFileName());
        $ids = $data->readDataFile();
       
        $item = $this->newItem();
        $arr = Model::getParamsPrivates($item, HTML::postParams());
        $data->update($arr);
        $data->saveDataFile();
        
        $this->indexAction();
        //IndexController::indexAction();
    }
    
    public function editAction() {
        $id = HTML::get("id");
        //echo "Edit id=".$id;//."---".self::getModelName().'+++'.Url::getModel();
        //exit();
        $data  = new Data($this->getModelFileName());
        //$ids = $data->readDataFile();
        $byId = $data->readDataFileById();
        $obj = $byId[$id];//$data->getById($id);
        $item = Model::loadModel($this->getModelName(), $obj);//new Book($id, $obj["name"], $obj["article"]);
        $form = new FormBuilder($item, Url::go($this->getModelName()."/update", ["id"=>$id]));
        $form->setLegend("Edit id=".$id);
        e::o ($form->getForm());
        
        $submit = $form->getSubmit("Сохранить");
        $submit->setDialogclose('myDialog');
        
        $close = new Button("Закрыть", "myDialog", "index.php", "actionClose");
        $content = $submit->getHTML();
        $content .= $close->getHTML();
        e::o (HTML::div("form-row", $content));
        //echo $submit->getHTML();
        //echo $close->getHTML();
    }
    
    public function delAction() {
        $id = HTML::get("id");
        $data  = new Data($this->getModelFileName());
        $ids = $data->readDataFile();
        $res = $data->del($id);
        if ($res){
            echo "Del id=".print_r($res, true);
            $data->saveDataFile();
        }
        
        $this->indexAction();
        //IndexController::indexAction();        
    }
}