<?php


/**
 * Description of Book
 *
 */
class Book extends Model {
    
    private string $id = '';
    
    /** Название */
    private string $name = '';
    
    /** Артикул */
    private string $article = ''; 
    
    /** Описание */
    private ?Textarea $info = null; 
    
    /** Тип публикации */
    private ?Select $typePublication = null; 
  
    /** Автор */
    private ?Author $author = null; 
    
    /** Пользователь */
    private ?User $user = null; 
    
    public function getId(): string {
        return $this->id;
    }
    
    static public function typePublicationOptions() {
        return [
          ["id"=>"1", "title"=>"Научная литература"],   
          ["id"=>"2", "title"=>"Газеты и журналы"],  
          ["id"=>"3", "title"=>"Художественная литература"],    
        ];
    }
    
    /*
    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(?User $user): void {
        $this->user = $user;
    }

    public function getAuthor(): ?Author {
       return $this->author;
    }

    public function setAuthor(?Author $author): void {
       $this->author = $author;
    }
    
    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getArticle(): string {
        return $this->article;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setArticle(string $article): void {
        $this->article = $article;
    }
    */
}
