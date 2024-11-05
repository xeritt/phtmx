<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orderwood', options : array("comment"=>"Заказ / Товар"))]
class OrderWood {
    
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
    
    #[ORM\ManyToOne(targetEntity: Order::class, cascade: array('persist'))]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', options : array('comment'=>'Заказ'))]
    private Order|null $order = null; 

    #[ORM\ManyToOne(targetEntity: Wood::class, cascade: array('persist'))]
    #[ORM\JoinColumn(name: 'wood_id', referencedColumnName: 'id', options : array('comment'=>'Товар'))]
    private Wood|null $wood = null; 

    #[ORM\Column(type: 'integer', options : array('comment'=>'Кол-во'))]
    private int $count = 0; 

    function setOrder($orderValue){ 
        $this->order = $orderValue;
    }

    function setWood($woodValue){ 
        $this->wood = $woodValue;
    }

    function setCount($countValue){ 
        $this->count = $countValue;
    }

    function getOrder(){ 
        return $this->order;
    }

    function getWood(){ 
        return $this->wood;
    }

    function getCount(){ 
        return $this->count;
    }

}
