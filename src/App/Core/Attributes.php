<?php

/**
 * Description of Attributes
 *
 */
class Attributes {
    
    public $COLUMN_ATTR_NAME = 'Doctrine\ORM\Mapping\Column';
    public $TABLE_ATTR_NAME = 'Doctrine\ORM\Mapping\Table';
    public $JOINCOLUMN_ATTR_NAME = 'Doctrine\ORM\Mapping\JoinColumn';
    
    public function get($prop) {
        return $prop->getAttributes();
    }
    
    public function getAttributeOptionValue($prop, $attrName, $opName) {
        $attrs = $this->get($prop);//$prop->getAttributes();
        foreach ($attrs as $attr) {
            //echo '['.$attr->getName().']';
            if ($attr->getName() != $attrName) continue;
            $args = $attr->getArguments();
            if (isset($args['options'][$opName])){
                return $args['options'][$opName];
            }
        }
        return '';
    }
    
    public function getAttributeValue($prop, $attrName, $opName) {
        $attrs = $this->get($prop);//$prop->getAttributes();
        foreach ($attrs as $attr) {
            //echo '['.$attr->getName().']';
            if ($attr->getName() != $attrName) continue;
            $args = $attr->getArguments();
            if (isset($args[$opName])){
                return $args[$opName];
            }
        }
        return '';
    }
}
