<?php

namespace LibrarySystem;

use LibrarySystem\Exceptions\InvalidPriceException;
use LibrarySystem\Exceptions\IdAlreadySetException;




//equire_once __DIR__ . '/Exception.php';

use JsonSerializable;
use Exception;
use LibrarySystem\Log;


class Book implements JsonSerializable {
    use log;
    private $id;
    private $title;
    private $author;
    private $price;
    private $isGiven = false;

    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->setPrice($price);
        $this->Add_log("Book created: {$title} by {$author}, price: {$price}"); 
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getPrice() {
        return $this->price;
    }

    public function isGiven() {
        return $this->isGiven;
    }

    public function setId($id) {
        if ($this->id !== null) {
            throw new IdAlreadySetException("id already set, cannot be changed");
        }
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setPrice($price) {
        if (!is_numeric($price) || $price < 0) {
            throw new InvalidPriceException("price can not be negative");
        }
        $this->price = $price;
    }

    public function setGiven(bool $given) {
        if (!is_bool($given)) {
            throw new Exception("type of given should be bool");
        }
        $this->isGiven = $given;
    }

    public function jsonSerialize(): array {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'author'  => $this->author,
            'price'   => $this->price,
            'isGiven' => $this->isGiven,
        ];
    }
}
