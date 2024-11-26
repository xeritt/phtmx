<?php

/** Тест */
class Test {
    
    private string $id = '';
    
    public function getId(): string {
        return $this->id;
    }
    
    /** Заголовок */
    private string $name = ''; 
    /** Дата создания */
    private string $dateCreate = ''; 
    /** Описание */
    private ?Textarea $info = null; 
    /** Пользователь */
    private ?User $user = null; 


}
