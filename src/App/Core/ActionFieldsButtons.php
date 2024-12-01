<?php

/**  */
class ActionFieldsButtons implements IComponent, IActionButtons{
    private $id;
    private $modelName;
    private $dialogTarget = "myDialog";
    
    private $buttons = [];
    
    public function createButtons() {
        $id = $this->id;
        $getModelName = $this->modelName;
        $params = Url::getParamsWithoutModelAction(HTML::getParams());
        $params = array_merge(["id"=>$id], $params);
        
        $up = new Button("Up", $getModelName, Url::go($getModelName."/up", $params));
        $down = new Button("Down", $getModelName, Url::go($getModelName."/down", $params));
        $edit = new Button("Edit", $this->dialogTarget, Url::go($getModelName."/edit", $params), 'loadDialog');
        $del = new Button("Del", $getModelName, Url::go($getModelName."/del", $params));
        $del->setConfirm("Вы хотите удалить id=".$id);

        $this->buttons = [
            'up'=>$up,
            'down'=>$down,
            'edit'=>$edit, 
            'del'=>$del
        ];
        
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
        $html = '';
        
        CSS::add('.menuButtons', 
        '
            position: absolute;
            padding: 5px;
            background-color:rgba(0, 0, 0, 0.5);
        ');
        
        $html .= "<style>
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

        </style>";
        return $html;
   }
    
   public function getHTML() {
        /*
        $id = $this->id;
        $getModelName = $this->modelName;
        
        $up = new Button("Up", $getModelName, Url::go($getModelName."/up",["id"=>$id]));
        $down = new Button("Down", $getModelName, Url::go($getModelName."/down",["id"=>$id]));
        $edit = new Button("Edit", $this->dialogTarget, Url::go($getModelName."/edit",["id"=>$id]), 'loadDialog');
        $del = new Button("Del", $getModelName, Url::go($getModelName."/del",["id"=>$id]));
        $del->setConfirm("Вы хотите удалить id=".$id);
        $html = $up->getHTML();
        $html .= $down->getHTML();
        $html .= $edit->getHTML();
        $html .= $del->getHTML();
        */
        $html = '';
        
        //if (!CSS::isLoad("ActionModelsButtons")){
          //  $html .= CSS::load("ActionModelsButtons", $this->getStyle()); 
        //}
        //echo get_class($this);
        //$html .= CSS::load(get_class($this), $this->getStyle()); 
        /*$css = HTML::tag('Загрузка ...', 'style', [
            'class'=>'loadDynamicText', 
            'data-target'=>$uid, 
            'data-url'=>Url::go("Css/load",["class"=>get_class($this)])
            ]
        );
        $html .= HTML::tag($css, 'div', ['id'=>$uid, 'class'=>'dynamicStyle']);
        */
        $html .= HTML::getLoadStyle('ActionButtons');
        $btms = '';
        foreach ($this->getButtons() as $key => $button) {
            $btms .= $button->getHTML();
            //$btms .= HTML::br();
        }
        $uid = HTML::uuid();
        
        $html .= HTML::tag($btms, 'div', ['id'=>$uid, 'class'=>'hide menuButtons']);
        $html = HTML::tag('||||', 'button', ['class'=>'toggleButton', 'data-target'=>$uid]).$html;
        $html = HTML::tag($html, 'div', ['class'=>'toggleArea']);
        //$html .= '</div>';
        return $html;
    }
}
