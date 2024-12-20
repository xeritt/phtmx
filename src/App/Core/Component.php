<?php

/**
 * Description of Component
 *
 */
class Component {
    
    protected $id;
    protected $class;
    protected $html;
    
    public function __construct($class) {
        $this->class = $class;
        $this->id = uniqid();
    }
    
    public function setId($id): void {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getClass() {
        return $this->class;
    }
    
    public function getHtml() {
        return $this->html;
    }

    public function setHtml($html): void {
        $this->html = $html;
    }

}
