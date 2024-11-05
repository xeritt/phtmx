<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orderservice', options : array("comment"=>"Заказ / Услуги"))]
class OrderService {
    
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

    #[ORM\ManyToOne(targetEntity: Service::class, cascade: array('persist'))]
    #[ORM\JoinColumn(name: 'service_id', referencedColumnName: 'id', options : array('comment'=>'Услуга'))]
    private Service|null $service = null; 

    #[ORM\Column(type: 'integer', options : array('comment'=>'Кол-во'))]
    private int $count = 0; 

    function setOrder($orderValue){ 
        $this->order = $orderValue;
    }

    function setService($serviceValue){ 
        $this->service = $serviceValue;
    }

    function setCount($countValue){ 
        $this->count = $countValue;
    }

    function getOrder(){ 
        return $this->order;
    }

    function getService(){ 
        return $this->service;
    }

    function getCount(){ 
        return $this->count;
    }

}
