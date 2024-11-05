<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orderstatus', options : array("comment"=>"Статус заказа"))]
class OrderStatus {
    
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
    
    #[ORM\Column(type: 'string', options : array('comment'=>'Название'))]
    private string $name = ''; 

    #[ORM\Column(type: 'string', options : array('comment'=>'Описание'))]
    private string $info = ''; 

    function setName($nameValue){ 
        $this->name = $nameValue;
    }

    function setInfo($infoValue){ 
        $this->info = $infoValue;
    }

    function getName(){ 
        return $this->name;
    }

    function getInfo(){ 
        return $this->info;
    }

}
