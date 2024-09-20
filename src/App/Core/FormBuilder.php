<?php

/**
 * Description of FormBuilder
 *
 */
class FormBuilder {
    
    private $model;
    private $method = 'POST';
    private $action;
    private $id;
    private $legend;
    private $style;
    
    public function __construct($model, $action) {
        $this->model = $model;
        $this->action = $action;
        $this->id = uniqid();
        //$this->id = 
    }

    public function getId() {
        return $this->id;
    }
    
    public function setLegend($legend): void {
        $this->legend = $legend;
    }
    
    public function getLegend() {
        return $this->legend;
    }

        
    /*
    public function loadScript($filename) {
        if (file_exists($filename)){
            $data = file_get_contents($filename);
            $data = '<script type="text/javascript" id="form-'.$this->getId().'">'.$data.'</script>';
            return $data;
        } 
        return null;
    }
    */
    public function getSubmit($text) {
        $submit = new Button($text, Url::getModel(), 'index.php', 'actionSubmit');
        $submit->setForm($this->getId());
        return $submit;
    }
    
    public function setStyle($style): void {
        $this->style = $style;
    }
    
    public function getDefaultStyle() {
        $html = '';
        $html .= "<style>
        .form-row{
            color:green; display: flex;
            justify-content: space-between;
        }
        .form-row input {
            padding: 0px 5px 0px 5px;
            margin: 0px 5px 5px 5px;
        }
        .form-row select {
            padding: 0px 5px 0px 5px;
            margin: 0px 5px 5px 5px;
        }
        </style>";
        return $html;
    }

    public function getStyle() {
        if (isset($this->style)){
            return $this->style;
        }
        return $this->getDefaultStyle();
    }

    
    public function getForm() {
        $html = '';
        if (isset($this->style)){
            
        } else {
            $html .= $this->getDefaultStyle();
        }    
        //$html .= '<fieldset><legend>Choose your favorite monster</legend>';
        $form = '<form';
        $form .= ' id="'.$this->id.'"';
        $form .= ' method="'.$this->method.'"';
        $form .= ' action="'.$this->action.'"';
        $form .= ' >';
        $form .= $this->getFormInputs();
        $form .= '</form>';
        //$html .= '</fieldset>';
        $html .= HTML::fieldset($form, $this->getLegend());;
        return $html;
    }
    
    public function getFormInputs() {
        $reflect = new ReflectionClass($this->model);
        $props   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        
        $legend = $reflect->getDocComment();
        if (!isset($this->legend)) $this->setLegend(trim($legend, "\**/"));
        //$typeInput = 'text';
        $html = '';
        foreach ($props as $prop) {
            $typeInput = 'text';
            $row = '';
            if ('id' == $prop->getName()){
                $typeInput = 'hidden';
            } 
            $comment = $prop->getDocComment();
            $row .= '<label for="'.$prop->getName().'">';
            if (isset($comment)){
                $row .= trim($comment, "\**/");
            }   
            $row .= '</label>';
            
            $prop->setAccessible(true);
            $value = '';
            $value = $prop->getValue($this->model);
            $row .= $this->getInput($reflect, $prop, $typeInput, $value);
            
            $html .= HTML::div("form-row", $row);
            //$html .= HTML::br();
        }
        
        return $html;
    }
    
    
    public function getInput($reflect, $prop, $typeInput, $value) {
        $types = Php::getTypes();
        $html = '';
        $type = ltrim($prop->getType(), '?');
        if (!in_array($type, $types)){
            $item = Model::create($type);
            if (Model::isInput($item)){
                if (Model::isModelSource($item)) {
                    $item->setModelName($reflect->getName()); 
                }    
                $name = $prop->getName();
                $item->setAttrs(["id"=>$name, "name"=>$name]);
                if ($value != null) $item->setValue($value->getValue());
                $html .= $item->getHTML();
            } else {
                if ($value != null) {
                    $value = $value->getId();
                }
                $html .= $this->getModelSelect(ltrim($prop->getType(), ''), $prop->getName(), $value);    
            }
            
        } else{
            $html .= '<input type="'.$typeInput.'" id="'.$prop->getName().'" name="'.$prop->getName().'" value="'.$value.'" />';
        }
        return $html;
    }
    
    
    public function getModelSelect($modelName, $propertyName, $value) {
        $modelName = ltrim($modelName, '?');
        $data  = new Data($modelName.".json");
        $ids = $data->readDataFile();
        $html = '';
        $html .= '<select name="'.$propertyName.'" id="'.$propertyName.'">';
        $html .= '<option value=""></option>';
        //print_r($obj);
        foreach ($ids["data"] as $key => $item) {
            $selected = '';
            
            if ($value == $item["id"]) $selected = 'selected';
            $keys = array_keys($item);
            
            $html .= '<option value="'.$item["id"].'" '.$selected.'>'.$item[$keys[1]].'</option>';
        }
        $html .= '</select>';
        return $html;
    }
}
