<?php

/**
 * Description of BaseController
 *
 */
class BaseController {
    
    //public $modelName = 'Book';
    public $isDoctrine = false;
    public $form;
    private string $title = 'Base Controller';
    
    public function __construct() {}
    
    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

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
        //print_r(HTML::getParams());
        $params = Url::getParamsWithoutModelAction(HTML::getParams());
        //print_r($params);
        if ($this->isDoctrine){
            //$params = Url::getParamsWithoutModelAction(HTML::getParams());
            $this->form = new DoctrineFormBuilder($item, Url::go($this->getModelName()."/new", $params));
        } else {
            $this->form = new FormBuilder($item, Url::go($this->getModelName()."/new", $params));//"index.php?page=Book&action=new");
        }    
        e::o ($this->form->getForm());
        $submit = $this->form->createSubmit("Добавить");
        $submit->setDialogclose('myDialog');
        e::o ($submit->getHTML());
        $close = new Button("Закрыть", "myDialog", "index.php", "actionClose");
        e::o ($close->getHTML());
    }
    
    public function newAction() {
        if ($this->isDoctrine){
            try {
                $item = Model::loadModel($this->getModelName(), HTML::postParams());
                //var_dump($item);
                //$item = $this->newItem();
                //$arr = Model::getParamsPrivates($item, HTML::postParams());
                $entityManager = Config::getEntityManager();
                $entityManager->persist($item);
                $entityManager->flush();
            } catch (Throwable $e) {
                    echo 'Something happens: '.$e->getMessage();
            }                
        } else {
            $item = $this->newItem();
            $arr = Model::getParamsPrivates($item, HTML::postParams());
            $arr["id"] = uniqid();            
            $data  = new Data($this->getModelFileName());
            $ids = $data->readDataFile();
            $data->add($arr);
            $data->saveDataFile();
        }    
        
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
    
    public function getItems($modelName = '') {
        $html = '';
        if ($modelName == '') $modelName = $this->getModelName();
        
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
        $params = Url::getParamsWithoutModelAction(HTML::getParams());
        $add = new Button("+ ".$modelName, "myDialog", Url::go($modelName."/add", $params), "loadDialog");
        $html .= $add->getHTML();
        //echo HTML::br();
        //echo HTML::br();
        
        //$html .= HTML::br();
        //$html .= HTML::br();
        return $html;
    }
    
    public function indexAction() {
        //$modelName = $this->getModelName();//Config::$modelName;
        e::o ($this->getItems());
        //$edit = new Button("Edit", 'main', "load.php?page=Book&action=edit");
        //echo $edit->getHTML();
    }
    
    public function updateAction() {
        
        if ($this->isDoctrine){
            echo $this->isDoctrine.'--------';
            try {
                    $entityManager = Config::getEntityManager();
                    $item = Model::loadModel($this->getModelName(), HTML::postParams(), 'edit');
                    //var_dump($item);
                    //$entityManager = Config::getEntityManager();
                    $entityManager->persist($item);
                    //$entityManager->merge($item);
                    $entityManager->flush();
                } catch (Throwable $e) {
                    e::o ('Something happens: '.$e->getMessage());
                }
            
        } else {
            $data  = new Data($this->getModelFileName());
            $ids = $data->readDataFile();

            $item = $this->newItem();
            $arr = Model::getParamsPrivates($item, HTML::postParams());
            $data->update($arr);
            $data->saveDataFile();
        }
        
        $this->indexAction();
        //IndexController::indexAction();
    }
    
    public function editAction() {
        $id = HTML::get("id");
        //echo "Edit id=".$id;//."---".self::getModelName().'+++'.Url::getModel();
        //exit();
        if ($this->isDoctrine){
            $entityManager = Config::getEntityManager();
            $item = $entityManager->find($this->getModelName(), $id);

                if ($item === null) {
                    echo $this->getModelName()."id=".$id." No found.\n";
                    //exit(1);
                } 
            $this->form = new DoctrineFormBuilder($item, Url::go($this->getModelName()."/update", ["id"=>$id]));
        } else {
            $data  = new Data($this->getModelFileName());
            //$ids = $data->readDataFile();
            $byId = $data->readDataFileById();
            $obj = $byId[$id];//$data->getById($id);
            $item = Model::loadModel($this->getModelName(), $obj);//new Book($id, $obj["name"], $obj["article"]);
            $this->form = new FormBuilder($item, Url::go($this->getModelName()."/update", ["id"=>$id]));
        }
        
        $this->form->setLegend("Edit id=".$id);
        e::o ($this->form->getForm());
        
        $submit = $this->form->createSubmit("Сохранить");
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
        if ($this->isDoctrine){
            try{
                $entityManager = Config::getEntityManager();
                $item = $entityManager->find($this->getModelName(), $id);

                if ($item === null) {
                    //echo "No product found.\n";
                    e::o ($this->getModelName()."id=".$id." No found.\n");
                    exit(1);
                }
                $entityManager->remove($item);
                $entityManager->flush();
            } catch (Throwable $e) {
                    echo 'Something happens: '.$e->getMessage();
            }
        } else {
            $data  = new Data($this->getModelFileName());
            $ids = $data->readDataFile();
            $res = $data->del($id);
            if ($res){
                echo "Del id=".print_r($res, true);
                $data->saveDataFile();
            }
        }
        $this->indexAction();
        //IndexController::indexAction();        
    }
    
    public function mainAction() {
        $view = new View();
        //$this->title = 'Title Base Controller';
        $m = $this->getModelName();
        $title = $this->getTitle();
        ///echo "Model:".$m;
        if ($view->view_exists($m.'/main')){
            //echo "render:".$m.'/main';
            $html = $view->render($m.'/main', ['model'=>$m]);
        } else {
            $html = $view->render('default/main', ['model'=>$m]);
        }    
        
        if ($view->layout_exists($m.'/main')){
            e::o($view->renderLayout($m.'/main', ['title'=>$title, 'content'=>$html]));    
        } else {
            e::o($view->renderLayout('default/main', ['title'=>$title, 'content'=>$html]));    
        }
    }
}
