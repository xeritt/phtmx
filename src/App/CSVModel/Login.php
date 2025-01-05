<?php


/** Login */
class Login {
    
    private string $id;
    
    /** Логин */
    private string $login;
    
    /** Пароль */
    private string $password;
    
    public function __construct(string $id = '', string $login = '', string $password = '') {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
    }

    
    public function getId(): string {
        return $this->id;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setLogin(string $login): void {
        $this->login = $login;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }



}
