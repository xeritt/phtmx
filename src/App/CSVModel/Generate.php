<?php

/** Генерация модели */
class Generate {

    private string $id = '';
    
    /** Модель */
    private ?Models $model = null;
    
    /** Описание */
    private ?Textarea $info = null;
    
    /** Группа (для файлов) */
    private string $group_name = '';
    
    public function getId(): string {
        return $this->id;
    }
    
}
