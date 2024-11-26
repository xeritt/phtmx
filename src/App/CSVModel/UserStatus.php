<?php

/** Статус */
class UserStatus {
    
    private string $id = '';
    /** Название */
    private string $name = '';
    /** Описание */
    private string $info = '';
    
    public function getId(): string {
        return $this->id;
    }

}
