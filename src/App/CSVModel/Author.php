<?php


/**
 * Description of Book
 *
 */
class Author {
    
    private string $id = '';
        
    /** Фамилия */
    private string $fname = '';

    /** Имя */
    private string $name = '';
    
    /** Отчество */
    private string $sname = '';    
    
    public function getId(): string {
        return $this->id;
    }
    /*
    public function __construct(string $id = '', string $fname = '', string $name = '', string $sname = '') {
        $this->id = $id;
        $this->fname = $fname;
        $this->name = $name;
        $this->sname = $sname;
    }

    public function getId(): string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFname(): string {
        return $this->fname;
    }

    public function getSname(): string {
        return $this->sname;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setFname(string $fname): void {
        $this->fname = $fname;
    }

    public function setSname(string $sname): void {
        $this->sname = $sname;
    }

    */
}
