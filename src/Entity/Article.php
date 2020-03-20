<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
    * @ORM\Column(type="string", length=255)
    */
    private $title;

    
    /**
    * @ORM\Column(type="string", length=255)
    */
    private $description;

    /**
    * @ORM\Column(type="text")
    */
    private $body;

    /**
    * @ORM\Column(type="text")
    */
    private $imageurl;

    //Getters and Setters
    public function getId() {
        return $this -> id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getImageUrl(){
        return $this->imageurl;
    }

    public function setImageUrl($imageurl) {
        $this->imageurl = $imageurl;
    }
}
