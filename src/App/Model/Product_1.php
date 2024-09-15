<?php

namespace model;
/** Продукт */
class Product {
    
    private string $id = '';
    
    public function getId(): string {
        return $this->id;
    }
    public function setId(string $id): void {
        $this->id = $id;
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
