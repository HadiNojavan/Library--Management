<?php

namespace LibrarySystem;

use LibrarySystem\CustomerStorage;
use LibrarySystem\LibraryStorage;
use LibrarySystem\Exceptions\InvalidNameException;
use LibrarySystem\Exceptions\IdAlreadySetException;
use LibrarySystem\Log; 
use JsonSerializable;//if i dont use this it will look in our LibrarySystem name space and wont found 




//require_once __DIR__ . '/CustomerStorage.php';
//require_once __DIR__ . '/LibraryStorage.php';
//require_once __DIR__ . '/Exception.php';

class Customer implements JsonSerializable {
     use Log;
    private $id;
    private $name;
    private $borrowedBooks = [];

    public function __construct($name) {
        $this->setName($name);
    }

    public function addPersonToLibrary() {
        $this->Add_log("Registering customer: " . $this->name);
        CustomerStorage::addCustomer($this);
    }

    public function borrowBookByTitle($title) {
        $this->Add_log("Customer {$this->name} borrowing book: {$title}");
        $borrowedBook = LibraryStorage::searchBookByTitle($title);
        CustomerStorage::addBorrowedBook($this->getId(), $borrowedBook);
    }

    public function borrowBookById($id) {
        $this->Add_log("Customer {$this->name} borrowing book by ID: {$id}");
        $borrowedBook = LibraryStorage::searchBookById($id);
        CustomerStorage::addBorrowedBook($this->getId(), $borrowedBook);
    }

    public function returnBookByTitle($title) {
         $this->Add_log("Customer {$this->name} returning book: {$title}");
        $returnedBook = LibraryStorage::returnBookByTitle($title);
        CustomerStorage::removeBorrowedBook($this->getId(), $returnedBook);
    }

    public function returnBookById($id) {
        $this->Add_log("Customer {$this->name} returning book by ID: {$id}");
        $returnedBook = LibraryStorage::returnBookById($id);
        CustomerStorage::removeBorrowedBook($this->getId(), $returnedBook);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        if ($this->id !== null) {
            throw new IdAlreadySetException("id already set, cannot be changed");
        }
        $this->id = $id;
    }

    public function setName($name) {
        if (!is_string($name) || trim($name) === "") {
            throw new InvalidNameException("name can not be empty");
        }
        $this->name = $name;
    }

    public function jsonSerialize(): array {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'borrowedBooks' => $this->borrowedBooks,
        ];
    }
}
