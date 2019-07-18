<?php

class Libro{

    private $title;
    private $data;
    private $img;
    private $price;
    private $link;
    private $author;

    public function __construct($title,$data,$img,$price,$link,$author)
    {   

        $this->title = $title;
        $this->img = $img;
        $this->data= $data;
        $this->link = $link;
        $this->price = $price;
        $this->author = $author;
    }   

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getData(){
        return $this->data;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function getImg(){
        return $this->img;
    }

    public function setImg($img){
        $this->img = $img;
    }

    public function getLink(){
        return $this->link;
    }

    public function setLink($link){
        $this->link = $link;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function setAuthor($author){
        $this->author = $author;
    }

}
?>