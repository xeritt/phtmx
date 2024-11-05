<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'client', options : array("comment"=>"Клиент"))]
class Client {
    
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    
    public function getId(): int|null {
        return $this->id;
    }

    public function setId(int|null $id): void {
        $this->id = $id;
    }
    
    #[ORM\Column(type: 'string', options : array('comment'=>'ФИО'))]
    private string $fio = ''; 

    #[ORM\Column(type: 'string', options : array('comment'=>'Email'))]
    private string $email = ''; 

    function setFio($fioValue){ 
        $this->fio = $fioValue;
    }

    function setEmail($emailValue){ 
        $this->email = $emailValue;
    }

    function getFio(){ 
        return $this->fio;
    }

    function getEmail(){ 
        return $this->email;
    }

}
