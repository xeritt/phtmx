<?php
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Description of Model
 *
 */
class Model {
    
    static public function isModelSource($item) {
         return $item instanceof IModelSource;
    }
    
    static public function isInput($item) {
         return $item instanceof IInput;
    }
    
    static public function getPrivates($model) {
        $reflect = new ReflectionClass($model);
        $props   = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        return $props;
    }
    
    /**
     * Возвращает массив приватных полей и их значений
     * 
     * @param type $model
     * @return array
     */
    static public function getArrayPrivates($model) {
        
        $props = self::getPrivates($model);
        $res = [];
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $name = $prop->getName();
            $value = $prop->getValue($model);
            $res[$prop->getName()] = $value;
        }
        
        return $res;
    }
    
    /**
     * Вывод массива приватных полей и их свойств
     * 
     * @param type $model
     * @return array
     */
    static public function getArrayProperties($model) {
        
        $props = self::getPrivates($model);
        $res = [];
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $name = $prop->getName();
            //$value = $prop->getValue($model);
            $res[$prop->getName()] = $prop;
        }
        
        return $res;
    }
    
    /**
     * Вывод массива приватных полей и их значений
     * с установкой из $params
     * 
     * @param type $model
     * @param type $params
     * @return array
     */
    
    static public function getParamsPrivates($model, $params) {
        
        $props = self::getPrivates($model);
        $res = [];
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $name = $prop->getName();
            $value = $params[$name];//$prop->getValue($model);
            $res[$prop->getName()] = $value;
        }
        
        return $res;
    }
    
    static public function getHeaders($modelName) {
        
        $props = self::getPrivates($modelName);
        $headers = [];
        foreach ($props as $prop) {
            $comment = $prop->getDocComment();
            $headers[$prop->getName()] = trim($comment, "\**/");
        }
        return $headers;
    }
    
    static public function getAnnotationLabels($modelName) {
        
        $props = self::getPrivates($modelName);
        $headers = [];
        $reader = new AnnotationReader();
        foreach ($props as $prop) {
        
            $annotation = $reader->getPropertyAnnotation(
                $prop,
                InputAnnotation::class
            );
            
            //$comment = $prop->getDocComment();
            //$headers[$prop->getName()] = trim($comment, "\**/");
            if (isset($annotation->label)) 
                $headers[$prop->getName()] = $annotation->label;
        }
        return $headers;
    }
    
    static public function getAttributesComents($modelName) {
        
        $props = self::getPrivates($modelName);
        $headers = [];
        $attrs = new Attributes();
        foreach ($props as $prop) {
            $comment = $attrs->getAttributeOptionValue($prop, $attrs->COLUMN_ATTR_NAME, 'comment');
            if ('' != $comment){
                $headers[$prop->getName()] = $comment;
            }
        }
        return $headers;
    }
    
    static public function create($name) {
        $str = '$item = new '. ltrim($name, '?').'();';
        echo $str;
        eval($str);
        return $item;
    }
    
    static public function loadModel($modelName, $params) {
        
        //$str = '$model = new '.$modelName.'();';
        //eval($str);
        $model = Model::create($modelName);
        //$model = new $modelName();
        $props = self::getPrivates($model);
        //$types = Php::getTypes();

        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $name = $prop->getName();
            if (isset($params[$name])){
                $propertyModelName = ltrim($prop->getType(), '?');
                //if (!in_array($propertyModelName, $types)){
                if (!Php::inTypes($propertyModelName)){
                    
                    $input = Model::create($propertyModelName);
                    if (Model::isInput($input)){
                        $input->setValue($params[$name]);
                        $prop->setValue($model, $input);
                    } else {
                    //echo "Start=".$propertyModelName."????";
                        $data  = new Data($propertyModelName.".json");
                        $ids = $data->readDataFile();
                        $obj = $data->getById($params[$name]);
                        $propertyModel  = Model::loadModel($propertyModelName, $obj);//new Author($obj['id'], $obj['fname'], '', '');//
                        $prop->setValue($model, $propertyModel);
                    }    
                } else {
                    //echo $params[$name];
                    
                    try {
                        $prop->setValue($model, $params[$name]);
                    } catch (Throwable $e) {
                        echo 'Something happens: '.$e->getMessage();
                    }
                }
            }
        }
        return $model; 
    }
}
