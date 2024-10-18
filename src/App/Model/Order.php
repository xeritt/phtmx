<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orders', options : array("comment"=>"Заказ"))]
class Order {
    
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
    
    #[ORM\Column(type: 'integer', options : array('comment'=>'Номер'))]
    private int $number = 0; 
    
    #[ORM\Column(type: 'datetime', options : array('comment'=>'Время создания'))]
    private DateTime|null $date_create = null; 

    #[ORM\ManyToOne(targetEntity: Client::class, cascade: array('persist'))]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', options : array('comment'=>'Клиент'))]
    //#[ORM\Column(type: 'integer', options : array('comment'=>'Клиент'))]
    private Client|null $client = null;

    #[ORM\ManyToOne(targetEntity: OrderStatus::class, cascade: array('persist'))]
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id', options : array('comment'=>'Статус заказа'))]
   //#[ORM\Column(type: 'integer', options : array('comment'=>'Статус заказа'))]
    private OrderStatus|null $status = null; 

    function setDate_create($date_createValue){ 
        $this->date_create = $date_createValue;
    }

    function setClient($clientValue){ 
        $this->client = $clientValue;
    }

    function setStatus($statusValue){ 
        $this->status = $statusValue;
    }

    function getDate_create(){ 
        return $this->date_create;
    }

    function getClient(){ 
        return $this->client;
    }

    function getStatus(){ 
        return $this->status;
    }

    public function getNumber(): int {
        return $this->number;
    }

    public function setNumber(int $number): void {
        $this->number = $number;
    }

}
