<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '%s', options : array("comment"=>"%s"))]
class %s {
    
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
    
%s}
