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
    public function generateAction() {
        $generate = new Button("Generate", 'Result', Url::go("Models/savefiles"));
        echo $generate->getHTML();
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
}
