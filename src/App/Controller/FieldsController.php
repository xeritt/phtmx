<?php

/**
 *
 */
class FieldsController extends BaseController{
    
    public function upAction() {
        $id = HTML::get("id");
        $data  = new Data($this->getModelFileName());
        //$ids = $data->readDataFile();
        $byId = $data->readDataFileById();
        $items = $data->getData()["data"];
        //print_r($items);
        for ($i=1; $i<count($items); $i++){
            if ($items[$i]["id"] == $id){
                echo "index=".$i;
                $tmp = $items[$i - 1];
                $items[$i - 1] = $items[$i];
                $items[$i] = $tmp;
                break;
            }
        }
        $newData = ["data"=>$items];
        $data->setData($newData);
        $data->saveDataFile();
        $this->indexAction();
    }
    
    public function downAction() {
        $id = HTML::get("id");
        $data  = new Data($this->getModelFileName());
        //$ids = $data->readDataFile();
        $byId = $data->readDataFileById();
        $items = $data->getData()["data"];
        //print_r($items);
        for ($i=0; $i<count($items) - 1; $i++){
            if ($items[$i]["id"] == $id){
                //echo "index=".$i;
                $tmp = $items[$i + 1];
                $items[$i + 1] = $items[$i];
                $items[$i] = $tmp;
                break;
            }
        }
        $newData = ["data"=>$items];
        $data->setData($newData);
        $data->saveDataFile();
        $this->indexAction();
    }
    
    public function getTable() {
        $modelName = $this->getModelName();
        $data  = new Data($this->getModelFileName());
        $findBy = HTML::get('findBy');
        print_r($_GET);
        if (isset($findBy)){
            echo "???????????";
            $ids = $data->readDataFileFindBy($findBy);    
        } else {
            echo "!!!!!";
            $ids = $data->readDataFile();    
        }
        $table = new Table($ids["data"]);
        $table->setModelName($modelName);
        $buttons = new ActionFieldsButtons();
        $buttons->createButtons();
        $table->setActionButtons($buttons);
        //$table->createButtons
        //$table->setStyle("color:red; border: 1px solid red;");
        $table->setClass("table");
        //echo "#*##*#*#*##*";
        return $table;
        //$html .= $table->getColTableHTML();
    }
}
