<?php

/**
 * Description of Select
 *
 */
class Select implements IInput, IModelSource{
    
    private $value = '';
    private $modelName = '';
    private array $attrs = [];
     
    public function getHTML() {
        return $this->getSelect();"select".$this->modelName;
    }

    public function setModelName($modelName): void {
        $this->modelName = $modelName;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value): void {
        $this->value = $value;
    }
    
    public function getAttrs(): array {
        return $this->attrs;
    }

    public function setAttrs(array $attrs): void {
        $this->attrs = $attrs;
    }
    
    public function getSelect() {
        
        $name = $this->modelName;
        $propertyName = $this->attrs["name"];
        $str = $propertyName."Options";
        //e::o($str);        
        //e::o($name);
        $values = $name::$str();
        //print_r($values);        
        //$data  = new Data($modelName.".json");
        //$ids = $data->readDataFile();
        $html = '';
        $html .= '<select name="'.$propertyName.'" id="'.$propertyName.'">';
        $html .= '<option value=""></option>';
        //print_r($obj);
        $current = $this->getValue();
        foreach ($values as $key => $item) {
            $selected = '';
            
            if ($current == $item["id"]) $selected = 'selected';
            $keys = array_keys($item);
            
            $html .= '<option value="'.$item["id"].'" '.$selected.'>'.$item[$keys[1]].'</option>';
        }
        $html .= '</select>';
        return $html;
    }
}
