<?php

/** Генерация модели */
class Generate {

    private string $id = '';
    
    /** Модель */
    private ?Models $model = null;
    
    /** Описание */
    private ?Textarea $info = null;
    
    public function getId(): string {
        return $this->id;
    }
    
}
