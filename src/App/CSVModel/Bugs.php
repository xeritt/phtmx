<?php

/** Ошибки */
class Bugs {
    
    private string $id = '';
    
    public function getId(): string {
        return $this->id;
    }
    
    /** Заголовок */
    private string $name = ''; 
    /** Описание */
    private ?Textarea $info = null; 
    /** Пользователь */
    private ?User $user = null; 
    /** Дата создания */
    private string $dateCreate = ''; 


}
