<?php

/** Textarea */
class Textarea implements IInput{
    
    private $value = '';
    private array $attrs = [];

    static public function tag($value, $attrs = []) {
        return HTML::tag($value, "textarea", $attrs);
    }
    
    public function getHTML() {
        //return HTML::tag($this->content, "area", $this->attrs);
        return self::tag($this->getValue(), $this->getAttrs());
    }
    
    public function getValue(){
        return $this->value;
    }

    public function setValue($value) : void {
        $this->value = $value;
    }

    public function getAttrs(): array {
        return $this->attrs;
    }

    public function setAttrs(array $attrs): void {
        $this->attrs = $attrs;
    }

}
