<?php

/**
 * Description of Calls
 *
 */
class Data {
    
    private $dataPath = "../data";
    private $data = [];
    //public $isAdd = false;
    private $isUpdate = false;
    private $fileName;

    /*public function __construct($dataPath) {
        $this->dataPath = $dataPath;
    }*/
    public function __construct($fileName) {
        $this->fileName = $fileName;
    }
    
    public function setDataPath($dataPath): void {
        $this->dataPath = $dataPath;
    }
    
    public function setFileName($fileName): void {
        $this->fileName = $fileName;
    }

    public function getData() {
        return $this->data;
    }
    
    public function setData($data): void {
        $this->data = $data;
    }

    public function getDataFileName() {
        if (isset($this->fileName))
            return $this->dataPath."/".$this->fileName;
        return $this->dataPath."/".date("Y-m-d") . ".json";
    }

    public function readDataFile() {
        $filename = $this->getDataFileName();
        $this->data = ["data" => []];

        if (file_exists($filename)){
            $json = file_get_contents($filename);
            $this->data = json_decode($json, true);
        } 
        return $this->data;
    }
    
    /**
     * Загружает данные в data и 
     * Возвращает массив данных где ключи id
     * @return array
     */
    public function readDataFileById() {
        $filename = $this->getDataFileName();
        $this->data = ["data" => []];
        //$this->data = [];
        $dataId = [];
        if (file_exists($filename)){
            $json = file_get_contents($filename);
            $this->data = json_decode($json, true);
            
            foreach ($this->data["data"] as $key => $value) {
                //if ($value["id"] == $id){    
                $dataId[$value["id"]] = $this->data["data"][$key];
                //}
            }    
        } 
        return $dataId;//$this->data;
    }
    
    public function saveDataFile() {
        $filename = $this->getDataFileName();
        $json = json_encode($this->data);
        file_put_contents($filename, $json);
    }
    
    public function add($id) {
        if (!in_array($id, $this->data["data"])) {
            $this->data["data"][] = $id;
            //$this->isAdd = true;
            $this->isUpdate = true;
        }    
    }
    /*
    public function inData($id) {
        return in_array($id, $this->data["data"]);
    }
    */
    public function del($id) {
        foreach ($this->data["data"] as $key => $value) {
            if ($value["id"] == $id){    
                $obj = array_splice ($this->data["data"], $key, 1);
                $this->isUpdate = true;
                return $obj;
            }    
        }
        return false;
    }
    
    public function getById($id) {
        foreach ($this->data["data"] as $key => $value) {
            if ($value["id"] == $id){    
                $obj = $this->data["data"][$key];
                return $obj;
            }    
        }
        return false;
    }
    
    public function update($item) {
        foreach ($this->data["data"] as $key => $value) {
            if ($value["id"] == $item["id"]){    
                $keys = array_keys($item);
                foreach ($keys as $fkey => $field) {
                    $this->data["data"][$key][$field] = $item[$field];
                    $this->isUpdate = true;
                }
                return true;
            }    
        }
        return false;
    }
}
