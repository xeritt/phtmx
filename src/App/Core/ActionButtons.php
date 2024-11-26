<?php

/**  */
class ActionButtons implements IComponent, IActionButtons{
    private $id;
    private $modelName;
    private $dialogTarget = "myDialog";
    private $buttons = [];
    
    public function createButtons() {
        $id = $this->id;
        $getModelName = $this->modelName;
        $controller = Application::getController();
        $action = Url::getAction();
        $this->buttons = [];
        echo $action;
        if (isset($controller->actionButtons[$action])){
            echo "?????";
            foreach ($controller->actionButtons[$action] as $func){
                $this->buttons[] = call_user_func($func, $id);
            }
        }
        $edit = new Button("Edit", $this->dialogTarget, Url::go($getModelName."/edit",["id"=>$id]), 'loadDialog');
        $del = new Button("Del", $getModelName, Url::go($getModelName."/del",["id"=>$id]));
        $del->setConfirm("Вы хотите удалить id=".$id);
        $this->buttons[] = $edit;
        $this->buttons[] = $del;
        /*
        $this->buttons = [
            'edit'=>$edit, 
            'del'=>$del
        ];*/
        
    }
    public function getButtons() {
        return $this->buttons;
    }

    public function setButtons($buttons): void {
        $this->buttons = $buttons;
    }

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

    public function getStyle() {
        
        $css = "
            .menuButtons{
                position: absolute;
                padding: 5px;
                background-color:rgba(0, 0, 0, 0.5);
                
            }
            .menuButtons button{
                width: 100%;
                padding: 2px;
            }
            .menuButtons button:hover{
                background-color: bisque;
            }
            .toggleArea{
                border: 0px solid red;
            }
            .toggleButton{
                padding: 2px 5px 2px 5px;
            }
        ";
        return $css;
   }
    
    public function getHTML() {
        /*
        $id = $this->id;
        $getModelName = $this->modelName;
        
        $edit = new Button("Edit", $this->dialogTarget, Url::go($getModelName."/edit",["id"=>$id]), 'loadDialog');
        $del = new Button("Del", $getModelName, Url::go($getModelName."/del",["id"=>$id]));
        $del->setConfirm("Вы хотите удалить id=".$id);
        $html = $edit->getHTML();
        $html .= $del->getHTML();
         * 
         */
        
        
        $html = '';
        //$html .= CSS::load(get_class($this), $this->getStyle()); 
        /*
        $uid = HTML::uuid('style_');
                $css = HTML::tag('Загрузка ...', 'style', [
            'class'=>'loadDynamicStyle', 
            'data-target'=>$uid, 
            'data-url'=>Url::go("Css/load",["class"=>get_class($this)]),
            //'data-dynamicstyleid'=>get_class($this)
            ]
        );
        $html .= HTML::tag($css, 'div', ['id'=>$uid, 'class'=>'dynamicStyle']);
        */
        $html .= HTML::getLoadStyle(get_class($this));
        $btms = '';
        foreach ($this->getButtons() as $key => $button) {
            //$html .= $button->getHTML();
            $btms .= $button->getHTML();
            //$btms .= HTML::br();
        }
        
        $uid = HTML::uuid();
        
        $html .= HTML::tag($btms, 'div', ['id'=>$uid, 'class'=>'hide menuButtons']);
        $html = HTML::tag('||||', 'button', ['class'=>'toggleButton', 'data-target'=>$uid]).$html;
        $html = HTML::tag($html, 'div', ['class'=>'toggleArea']);
        return $html;
    }
}
