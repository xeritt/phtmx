<?php


/** Пользователь */
class User {
    
    private string $id = '';
    
    /** Логин */
    private string $login = '';
    
    /** Email */
    private string $mail = '';
    
    /** Пароль */
    private string $password ='';
    
    /** Повтор пароля */
    private string $passwordReply = '';
    
    /** Дата создания */
    private string $dateCreate = '';
    
    /** Статус */
    private ?UserStatus $status = null;
    
    public function getId(): string {
        return $this->id;
    }
    
    /*
    public function __construct(string $id = '', string $login = '', string $mail = '', string $password = '', string $passwordReply = '', string $dateCreate = '', int $status = 0) {
        $this->id = $id;
        $this->login = $login;
        $this->mail = $mail;
        $this->password = $password;
        $this->passwordReply = $passwordReply;
        $this->dateCreate = $dateCreate;
        $this->status = $status;
    }


    public function getLogin(): string {
        return $this->login;
    }

    public function getMail(): string {
        return $this->mail;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getPasswordReply(): string {
        return $this->passwordReply;
    }

    public function getDateCreate(): string {
        return $this->dateCreate;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setLogin(string $login): void {
        $this->login = $login;
    }

    public function setMail(string $mail): void {
        $this->mail = $mail;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setPasswordReply(string $passwordReply): void {
        $this->passwordReply = $passwordReply;
    }

    public function setDateCreate(string $dateCreate): void {
        $this->dateCreate = $dateCreate;
    }

    public function setStatus(int $status): void {
        $this->status = $status;
    }
*/

}
