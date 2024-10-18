<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'wood', options : array("comment"=>"Товар"))]
class Wood {
    
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

    #[ORM\Column(type: 'string', options : array('comment'=>'Артикул'))]
    private string $article = ''; 

    #[ORM\Column(type: 'string', options : array('comment'=>'Описание'))]
    private string $info = ''; 

    #[ORM\Column(type: 'integer', options : array('comment'=>'Цена'))]
    private int $cost = 0; 

    function setName($nameValue){ 
        $this->name = $nameValue;
    }

    function setArticle($articleValue){ 
        $this->article = $articleValue;
    }

    function setInfo($infoValue){ 
        $this->info = $infoValue;
    }

    function setCost($costValue){ 
        $this->cost = $costValue;
    }

    function getName(){ 
        return $this->name;
    }

    function getArticle(){ 
        return $this->article;
    }

    function getInfo(){ 
        return $this->info;
    }

    function getCost(){ 
        return $this->cost;
    }

}
