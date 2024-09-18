<?php

/**
 * Description of Table
 *
 */
class Table {
    private $data;
    private $style;
    private $class;
    private $modelName;// = 'Book';
    private $ignoreFieldNames = ['password', 'passwordReply', 'id'];
    private $headers = []; //th
    static private bool $isStyleLoad = false;
    private IActionButtons $actionButtons; //Action buttons

    public function __construct($data) {
        $this->data = $data;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function setHeaders($headers): void {
        $this->headers = $headers;
    }

    public function setStyle($style): void {
        $this->style = $style;
    }
    public function setClass($class): void {
        $this->class = $class;
    }

    public function setModelName($modelName): void {
        $this->modelName = $modelName;
    }
    
    public function getModelName() {
        return $this->modelName;
    }

    public function setIgnoreFieldNames($ignoreFieldNames): void {
        $this->ignoreFieldNames = $ignoreFieldNames;
    }

    public function getIgnoreFieldNames() {
        return $this->ignoreFieldNames;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data): void {
        $this->data = $data;
    }

    public function getTableTag() {
        $html = '<table';
        if (isset($this->style)) {
            $html .= ' style="'.$this->style.'"'; 
        }    
        if (isset($this->class)) {
            $html .= ' class="'.$this->class.'"'; 
        }    
        $html .= ">";
        return $html;
    }
    
    public function getTableHeaders() {
        if (count($this->headers)==0) return;
        
        $html = '<tr>';
        $html .= '<th></th>';//actions
        //$html .= '<th></th>';
        foreach ($this->headers as $key => $value) {
            if (in_array($key, $this->ignoreFieldNames)) continue;
            $html .= '<th>';
            $html .= $value;
            $html .= '</th>';
        }
        $html .= '</tr>';
        return $html;
    }
    
    public function getActionButtons(): IActionButtons {
        return $this->actionButtons;
    }

    public function setActionButtons(IActionButtons $actionButtons): void {
        $this->actionButtons = $actionButtons;
    }

        
    public function getButtons($id) {
        if (!isset($this->actionButtons)) $this->actionButtons = new ActionButtons();
        $this->actionButtons->setId($id);
        $this->actionButtons->setModelName($this->getModelName());
        $this->actionButtons->createButtons();
        return $this->actionButtons->getHTML();
    }
    
    public function getStyle() {
        $html = '';
        $html .= "<style>
            table, th, td {
                border: 1px solid gray;
                border-collapse: collapse;
                padding: 3px;
            }
        </style>";
        return $html;
    }    
    
    public function getModelValue(&$datas, $field, $row, $type) {
        $keys_datas = array_keys($datas);
        $curData = null;
        $html = '';
        //$propName = $props[$arvalue]->getName();
        $data = new Data($type.'.json');
        $ids = $data->readDataFile();
        /*
        if (in_array($field ,$keys_datas)){
            $curData = $datas[$field];
        } else {
            //$data = new Data($type.'.json');
            //$html .= $type;
            $ids = $data->readDataFile();
            $datas[$field] = $ids;
            $curData = $datas[$field];
           
        }*/
        //if (!isset($curData)) $html .= "Err dat";
        //echo $id;
        $id = $row[$field];
        $item = $data->getById($id);
        //print_r($item);
        
        $k = array_keys($item);
        $val = $item[$k[1]];
        if (!isset($val) || $val=='') $val = '&nbsp;';
        $html .= $val;
        return $html;
    }
    
    public function modelSource(&$td, $row, $field) {
        $id_option = $row[$field];
        $str = $this->modelName."::".$field."Options";
        $options = $str();
        foreach ($options as $option_key => $option) {
            if ($id_option == $option["id"]){
                $td .= $option["title"];
                break;
            }
        }
    }
    
    public function getColTableHTML() {
        $html = '';
        if (!self::$isStyleLoad){
            $html .= $this->getStyle();
            self::$isStyleLoad = true;
        }
        $html .= $this->getTableTag();//"<table>";
        $headers = Model::getHeaders($this->modelName);
        $this->setHeaders($headers);
        $html .= $this->getTableHeaders();
        $props = Model::getArrayProperties($this->modelName);
        $datas = [];
        
        foreach ($this->data as $key => $row) {
            $tr = '';
            $td = $this->getButtons($row["id"]);
            $tr .= HTML::tag($td, "td");
            $keys_row = array_keys($row);
            foreach ($keys_row as $arkey => $field) {
                if (in_array($field, $this->ignoreFieldNames)) continue;
                $td = "";//"<td>";    
                $type = $props[$field]->getType();
                if (!Php::inTypes($type)){
                    $item = Model::create($type);
                    if (Model::isInput($item)){ //$item instanceof IInput){
                        if (Model::isModelSource($item)){
                            $this->modelSource($td, $row, $field);
                        } else {
                            $td .= $row[$field];//.'?????'.$props[$field]->getValue();
                        }    
                    } else {
                        $td .= $this->getModelValue($datas, $field, $row, $type);
                    }
                } else {
                    $td .= $row[$field];
                }    
                $tr .= HTML::tag($td, "td");
            }
            $html .= HTML::tag($tr, "tr");
        }
        $html .= "</table>";
        return $html;
    }
    
    public function getRowTableHTML() {
        
        $html = $this->getTableTag();//"<table>";
        $html .= "<tr>";
        for ($i=0; $i<count($this->data); $i++){
            $html .= "<td>";
            $html .= $this->data[$i];
            $html .= "</td>";
        }
        $html .= "</tr>";
        $html .= "</table>";
        return $html;
    }    
}
