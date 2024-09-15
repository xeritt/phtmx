<?php

/**  */
class ActionButtons implements IComponent, IActionButtons{
    private $id;
    private $modelName;
    private $dialogTarget = "myDialog";
    
    /*public function __construct($id, $modelName, $dialogTarget = "myDialog") {
        $this->id = $id;
        $this->modelName = $modelName;
        $this->dialogTarget = $dialogTarget;
    }
*/
    public function getId() {
       return $this->id;
    }

    public function getModelName() {
       return $this->modelName;
    }

    public function getDialogTarget() {
       return $this->dialogTarget;
    }

    public function setId($id): void {
       $this->id = $id;
    }

    public function setModelName($modelName): void {
       $this->modelName = $modelName;
    }

    public function setDialogTarget($dialogTarget): void {
       $this->dialogTarget = $dialogTarget;
    }

    
    public function getHTML() {
        $id = $this->id;
        $getModelName = $this->modelName;
        
        $edit = new Button("Edit", $this->dialogTarget, Url::go($getModelName."/edit",["id"=>$id]), 'loadDialog');
        $del = new Button("Del", $getModelName, Url::go($getModelName."/del",["id"=>$id]));
        $del->setConfirm("Вы хотите удалить id=".$id);
        $html = $edit->getHTML();
        $html .= $del->getHTML();
        return $html;
    }
}
