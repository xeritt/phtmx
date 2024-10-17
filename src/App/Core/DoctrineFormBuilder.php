<?php

/**
 * Description of FormBuilder
 *
 */
class DoctrineFormBuilder {
    
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
        
        //$legend = $reflect->getDocComment();
        $attrs = new Attributes();
        $legend = $attrs->getAttributeOptionValue($reflect, $attrs->TABLE_ATTR_NAME, 'comment');
        
        if (!isset($this->legend)) $this->setLegend(trim($legend, "\**/"));
        //$typeInput = 'text';
        $html = '';
        foreach ($props as $prop) {
            $typeInput = 'text';
            $row = '';
            if ('id' == $prop->getName()){
                $typeInput = 'hidden';
            } 
            //$comment = $prop->getDocComment();
            $comment = $attrs->getAttributeOptionValue($prop, $attrs->COLUMN_ATTR_NAME, 'comment');
            if ($comment == ''){
                $comment = $attrs->getAttributeOptionValue($prop, $attrs->JOINCOLUMN_ATTR_NAME, 'comment');
            }
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
            //echo "typeeeee===".$type;
            $item = Model::create($type);
            //echo "1";
            //var_dump($item);
            if (Model::isInput($item)){
                if (Model::isModelSource($item)) {
                    $item->setModelName($reflect->getName()); 
                }    
                //echo "2";
                $name = $prop->getName();
                $item->setAttrs(["id"=>$name, "name"=>$name]);
                if ($value != null) $item->setValue($value->getValue());
                $html .= $item->getHTML();
            } if ($type == 'DateTime'){
                //$html .= '???';
                $value  = date('Y-m-d H:i:s');
                $html .= '<input type="'.$typeInput.'" id="'.$prop->getName().'" name="'.$prop->getName().'" value="'.$value.'" />';
            } else {
                //echo "3";
                if ($value != null) {
                    $value = $value->getId();
                }
                if (Model::isEntity($item)){
                    //$reflect = new ReflectionClass($item);
                    //$props   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
                    //$legend = $reflect->getDocComment();
                    $attrs = new Attributes();
                    $fieldName = $attrs->getAttributeValue($prop, $attrs->JOINCOLUMN_ATTR_NAME, 'name');
                    //echo '$fieldName='.$fieldName.' propName='.$prop->getName().' value='.$value;
                    $html .= $this->getModelSelect($type, $fieldName, $value);    
                } else {
                    $html .= $this->getModelSelect($type, $prop->getName(), $value);    
                }    
            }
            
        } else{
            $html .= '<input type="'.$typeInput.'" id="'.$prop->getName().'" name="'.$prop->getName().'" value="'.$value.'" />';
        }
        return $html;
    }
    
    
    public function getModelSelect($modelName, $propertyName, $value) {
        //echo "5".$modelName;
        $entityManager = Config::getEntityManager();
        $itemRepository = $entityManager->getRepository($modelName);
        $items = $itemRepository->findAll();
        //print_r($items);
        //$data  = new Data($modelName.".json");
        //$ids = $data->readDataFile();
        $html = '';
        $html .= '<select name="'.$propertyName.'" id="'.$propertyName.'">';
        $html .= '<option value=""></option>';
        //print_r($obj);
        //foreach ($ids["data"] as $key => $item) {
        $props = Model::getPrivates($modelName);
        $fieldName = $props[1]->getName();        
        $getter = 'get'.ucfirst($fieldName);
        //$td .= $row->$m;//$row[$field];//.'?????'.$props[$field]->getValue();
        //echo $getter.'======';
        foreach ($items as $key => $item) {
            $selected = '';
            
            if ($value == $item->getId()) $selected = 'selected';
            //$keys = array_keys($item);
            //$item[$keys[1]]
            $item_val = $item->$getter();
            $html .= '<option value="'.$item->getId().'" '.$selected.'>'.$item_val.'</option>';
        }
        $html .= '</select>';
        return $html;
    }
}
