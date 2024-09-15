<?php

/** Модель */
class Models {

    private string $id = '';
    
    /** Название */
    private string $name = '';
    
    /** Коментарий */
    private string $comment = '';
    
    /** Описание */
    private string $info = '';
    
    /** Правила */
    private ?Textarea $rules = null;
    
    public function getId(): string {
        return $this->id;
    }
    
}
