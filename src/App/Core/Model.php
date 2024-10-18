<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
//use Doctrine\Common\Util\ClassUtils;

/**
 * Description of Model
 *
 */
class Model {
    
    static public function isModelSource($item) {
         return $item instanceof IModelSource;
    }
    
    /**
     * Если наследуется от IInput для поля ввода
     * @param IInput $item
     * @return type
     */
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
            if ($comment == ''){
                $comment = $attrs->getAttributeOptionValue($prop, $attrs->JOINCOLUMN_ATTR_NAME, 'comment');
            }
            if ('' != $comment){
                $headers[$prop->getName()] = $comment;
            }
        }
        return $headers;
    }
    
    static public function create($name) {
        $str = '$item = new '. ltrim($name, '?').'();';
        //echo $str;
        eval($str);
        return $item;
    }
    
    static public function loadModel($modelName, $params, $mode = 'new') {
        
        //$str = '$model = new '.$modelName.'();';
        //eval($str);
        //echo $modelName."!@!@!@!@";
        $entityManager = Config::getEntityManager();
        if ($mode == 'edit'){
            $model = $entityManager->find($modelName, $params['id']);
            //$model = Model::create($modelName);
        } else {
            $model = Model::create($modelName);
        }
        //$model = new $modelName();
        $props = self::getPrivates($model);
        //$types = Php::getTypes();
        //print_r($props);
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $name = $prop->getName();
            //echo "Name: $name <br />";
            $propertyModelName = ltrim($prop->getType(), '?');
            //echo "[propertyModelName=".$propertyModelName."].<br />";
            
                           
                //if (!in_array($propertyModelName, $types)){
            if (!Php::inTypes($propertyModelName)){
                $isEntity = self::isEntity($propertyModelName);
                if ($isEntity){
                    //echo "Oo this is entity $name";

                    $attrs = new Attributes();
                    $fieldName = $attrs->getAttributeValue($prop, $attrs->JOINCOLUMN_ATTR_NAME, 'name');
                    $propertyModel = $entityManager->find($propertyModelName, $params[$fieldName]);
                    //$entityManager->persist($item);
                    //$entityManager->flush();
                    $prop->setValue($model, $propertyModel);
                } else if (isset($params[$name])){       
                    //echo "!@@@";
                    $input = Model::create($propertyModelName);
                    //echo "%%%%%%";
                    if (Model::isInput($input)){
                        $input->setValue($params[$name]);
                        $prop->setValue($model, $input);
                    } else {
                        if ($propertyModelName == 'DateTime'){
                            //$date->format('Y-m-d H:i:s');
                            $prop->setValue($model, $input);
                        } else {
                            $data  = new Data($propertyModelName.".json");
                            $ids = $data->readDataFile();
                            $obj = $data->getById($params[$name]);
                            $propertyModel  = Model::loadModel($propertyModelName, $obj);//new Author($obj['id'], $obj['fname'], '', '');//
                            $prop->setValue($model, $propertyModel);
                        }
                    }    
                } 
            } else { //Если обычные типы php
                    //echo $params[$name];
                    try {
                        $prop->setValue($model, $params[$name]);
                    } catch (Throwable $e) {
                        echo 'Something happens: '.$e->getMessage();
                    }
            }
        }
        return $model; 
    }
    
    static public function loadDoctrineModelById($modelName, $id) {
        $entityManager = Config::getEntityManager();
        $item = $entityManager->find($modelName, $id);
        return $item;
    }
    
    /**
    * @param string|object $class
    *
    * @return boolean
    */
   static public function isEntity($class) {
       $em = Config::getEntityManager();
       
       if(is_object($class)){
           //$class = ClassUtils::getClass($class);
           $class = $em->getClassMetadata(get_class($class))->getName();
       } else {
           if (Php::inTypes($class)) return false;
       }
       return ! $em->getMetadataFactory()->isTransient($class);
   }
   
    /** Выдает тип из php в тип doctrine
     * 
     * @param type $type
     * @return string
     */
    static public function getDoctrineType($type) {
       switch ($type) {
           case 'int':
               return 'integer';
               break;
           default:
               return $type;
               break;
       }
   }
}
