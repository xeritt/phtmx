<?php

//namespace model;
/**
 * Description of User
 *
 */
class Rules {
    
    private string $id = '';
    
    /** Логин */
    private string $login = '';
    
    /** Контроллер */
    private string $controller = '';
    
    /** События */
    private ?Textarea $actions = null;
    
    public function getRules() {
        return [
          "admin" => ['index', 'new', 'add', 'del', 'update', 'edit']  
        ];
    }
    /*
    public function __construct(string $id = '', string $login = '', $controller = '', $actions = '') {
        $this->id = $id;
        $this->login = $login;
        $this->controller = $controller;
        $this->actions = $actions;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function getController(): string {
        return $this->controller;
    }

    public function getActions(): string {
        return $this->actions;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setLogin(string $login): void {
        $this->login = $login;
    }

    public function setController(string $controller): void {
        $this->controller = $controller;
    }

    public function setActions(string $actions): void {
        $this->actions = $actions;
    }

*/
}
