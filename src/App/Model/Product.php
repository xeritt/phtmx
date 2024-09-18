<?php
// src/Product.php
//namespace App\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products', options : array("comment"=>"Товар"))]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    
    #[ORM\Column(type: 'string', options : array("comment"=>"Название"))]
    private string $name = '';

    public function getId(): int|null {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setId(int|null $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

        // .. (other code)
}

