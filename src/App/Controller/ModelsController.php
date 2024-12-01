<?php

/**
 *
 */
class ModelsController extends BaseController{
    //put your code here
    /*
    public function indexAction() {
        $modelName = $this->getModelName();//Config::$modelName;
        e::o ($this->getItems($modelName));
    }
    */
    public $actionButtons = [];
    
    public function __construct() {
      //  parent::__construct();

        $this->actionButtons['index'][] = function ($id){
            $modelName = 'Fields';//Url::getModel();
            $view = new Button("Поля", $modelName, '', 'linkButton');
            $view->setHref(Url::go($modelName."/main", ["findBy[model]"=>$id]));
            return $view;
        };
    }
    
    public function generateAction() {
        $generate = new Button("Generate", 'Result', Url::go("Models/savefiles"));
        e::o ($generate->getHTML());
    }
    
    public function savefilesAction() {
        e::o("??");
        e::o($this->generateController());
        e::o("!!");
    }
    
    
    
    public function generateController() {
        $modelName = "Test";
        //$filename = "/var/www/html/jsonlib/tpl/phtmx/ModelController.php";
        $filename = "tpl/phtmx/ModelController.php";
        $text = htmlspecialchars(file_get_contents($filename));
        $res = sprintf($text, "Comment", "Modelname");
        
        //echo "????".$filename;
        //$text = "#######";
        //$text = file_get_contents($filename);
        //echo $text;
        return $res;
        
    }
    
    public function mainAction() {
        $view = new View();
        $title = 'Title Base Controller';
        $html = $view->render('Models/main', ['model'=>$this->getModelName()]);
        echo $view->renderLayout('default/main', ['title'=>$title, 'content'=>$html]);
    }
}
