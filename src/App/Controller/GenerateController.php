<?php

/**
 */
class GenerateController extends BaseController{
    
    public function head($fileName) {
        e::br();
        e::o('Файл: '.$fileName);
        e::br();
        e::o('-----------------------------------------');
        e::br();
    }
    
    public function tail() {
        e::br();
        e::o('^^^^^^^^^^^^^^^^^^^^^^^');
        e::br();
    }
    
    public function format($fileName, $text) {
        $this->head($fileName);
        e::o($text);
        $this->tail();
    }
    
    public function newAction() {
        $this->indexAction();
        
        $id = HTML::post("model");
        $fileController = "../tpl/phtmx/ModelController.php";
        $text = file_get_contents($fileController);
        $data  = new Data("Models.json");
        $ids = $data->readDataFile();
        $obj = $data->getById($id);
        
        $res = sprintf($text, $obj["comment"], $obj["name"]);
        $fileControllerDest = "../controller/".$obj["name"]."Controller.php";
        file_put_contents($fileControllerDest, $res);
        chmod($fileControllerDest, 0775);
        
        //$this->title($fileControllerDest);
        //echo htmlspecialchars($res);
        //$this->tail();
        $this->format($fileControllerDest, htmlspecialchars($res));
        
        $fileModel = "../tpl/phtmx/model.html";
        $fileModelDest = strtolower($obj["name"]).".html";
        $textModel = file_get_contents($fileModel);
        $res = sprintf($textModel, $obj["name"], $obj["name"], strtolower($obj["name"]));
        file_put_contents($fileModelDest, $res);
        chmod($fileModelDest, 0775);
        //echo htmlspecialchars($res);
        $this->format($fileModelDest, htmlspecialchars($res));

        $fileModel = "../tpl/phtmx/model.js";
        $fileModelDest = "js/".strtolower($obj["name"]).".js";
        $textModel = file_get_contents($fileModel);
        $res = sprintf($textModel, $obj["name"], $obj["name"], $obj["name"]);
        file_put_contents($fileModelDest, $res);
        chmod($fileModelDest, 0775);
        //echo htmlspecialchars($res);
        $this->format($fileModelDest, htmlspecialchars($res));


        $fileModel = "../tpl/phtmx/Model.php";
        $fileModelDest = "../model/".$obj["name"].".php";
        $textModel = file_get_contents($fileModel);
        
        
        $data  = new Data("Fields.json");
        $ids = $data->readDataFile();
        $code = "";
        foreach ($ids["data"] as $key => $value) {
            if ($value["model"] == $id){
                //echo $value["name"];
                $code .= "    "."/** {$value["comment"]} */\n";
                if ($value["type"] == 'string') {
                    $value["value"] = "'".$value["value"]."'";
                }    
                //$code .= "    ".'private '.$value['type'].' $'.$value['name'].' = '.$value['value'].";\n";
                $code .= "    private {$value['type']} $".$value['name']." = {$value['value']}; \n";
            }
        }
        
        $res = sprintf($textModel, $obj["comment"], $obj["name"], $code);
        file_put_contents($fileModelDest, $res);
        chmod($fileModelDest, 0775);
        //echo htmlspecialchars($res);
        $this->format($fileModelDest, htmlspecialchars($res));
        //$obj = $data->getById($id);
        
        //IndexController::indexAction();
        
    }
}
