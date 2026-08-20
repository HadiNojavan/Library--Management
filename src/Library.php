<?php

namespace LibrarySystem;

use LibrarySystem\LibraryStorage;

use LibrarySystem\Log;

class Library {

    use log;

    public function addBook(Book $book) {
        $this->Add_log("Adding book: " . $book->getTitle());
        LibraryStorage::addBook($book);
    }

    public function removeBook($title) {
        $this->Add_log("Removing book: " . $title);
        LibraryStorage::removeBookByTitle($title);
    }

    public function getBooks() {
        LibraryStorage::getAllBooks();
    }

    public function getCountBooks() {
        return count(LibraryStorage::loadData());
    }
}
