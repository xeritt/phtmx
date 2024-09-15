<?php

/**
 *
 */
interface IInput {
    public function getHTML(); 
    public function setValue($value):void;
    public function getValue();
    public function getAttrs(): array;
    public function setAttrs(array $attrs): void;
}
