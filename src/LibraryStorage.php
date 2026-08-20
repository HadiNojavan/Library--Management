<?php

namespace LibrarySystem;

use LibrarySystem\Exceptions\BookNotFoundException;
use LibrarySystem\Exceptions\BookAlreadyGivenException;
use LibrarySystem\Exceptions\BookNotGivenException;




//require_once __DIR__ . '/Exception.php';
//require_once __DIR__ . '/JsonStorage.php';
//require_once __DIR__ . '/Book.php';

class LibraryStorage extends JsonStorage {

    protected static function getFilePath(): string {
        return __DIR__ . '/../data/report_Library.json';
    }

    public static function addBook(Book $newBook) {
        $id = self::getNextId();
        $newBook->setId($id);
        $books = self::loadData();
        $books[] = $newBook;
        self::saveData($books);
    }

    public static function removeBookByTitle($title) {
        $books = self::loadData();
        foreach ($books as $key => $book) {
            if ($book["title"] === $title) {
                unset($books[$key]);
            }
        }
        $books = array_values($books);
        self::saveData($books);
    }

    public static function searchBookByTitle($title) {
        $books = self::loadData();
        $found = false;
        $borrowedBook = null;

        foreach ($books as $key => $book) {
            if (strtolower($book["title"]) === strtolower($title)) {
                if ($book["isGiven"] === true) {
                    throw new BookAlreadyGivenException("book with title '{$title}' is already given");
                }
                $books[$key]["isGiven"] = true;
                $found = true;
                $borrowedBook = $books[$key];
                break;
            }
        }

        if (!$found) {
            throw new BookNotFoundException("book with title '{$title}' not found");
        }

        self::saveData($books);
        return $borrowedBook;
    }

    public static function searchBookById($id) {
        $books = self::loadData();
        $found = false;
        $borrowedBook = null;

        foreach ($books as $key => $book) {
            if ($book["id"] === $id) {
                if ($book["isGiven"] === true) {
                    throw new BookAlreadyGivenException("book with id '{$id}' is already given");
                }
                $books[$key]["isGiven"] = true;
                $found = true;
                $borrowedBook = $books[$key];
                break;
            }
        }

        if (!$found) {
            throw new BookNotFoundException("book with id '{$id}' not found");
        }

        self::saveData($books);
        return $borrowedBook;
    }

    public static function returnBookByTitle($title) {
        $books = self::loadData();
        $found = false;
        $returnedBook = null;

        foreach ($books as $key => $book) {
            if (strtolower($book["title"]) === strtolower($title)) {
                if ($book["isGiven"] === false) {
                    throw new BookNotGivenException("book with title '{$title}' is not given to anybody!");
                }
                $books[$key]["isGiven"] = false;
                $found = true;
                $returnedBook = $books[$key];
                break;
            }
        }

        if (!$found) {
            throw new BookNotFoundException("book with title '{$title}' not found");
        }

        self::saveData($books);
        return $returnedBook;
    }

    public static function returnBookById($id) {
        $books = self::loadData();
        $found = false;
        $returnedBook = null;

        foreach ($books as $key => $book) {
            if ($book["id"] === $id) {
                if ($book["isGiven"] === false) {
                    throw new BookNotGivenException("book with id '{$id}' is not given to anybody!");
                }
                $books[$key]["isGiven"] = false;
                $found = true;
                $returnedBook = $books[$key];
                break;
            }
        }

        if (!$found) {
            throw new BookNotFoundException("book with id '{$id}' not found");
        }

        self::saveData($books);
        return $returnedBook;
    }

    public static function getAllBooks() {
        $books = self::loadData();

        echo str_pad("ID", 5)
           . str_pad("Title", 25)
           . str_pad("Author", 20)
           . str_pad("Price", 12)
           . "Status" . PHP_EOL;

        echo str_repeat("-", 65) . PHP_EOL;

        foreach ($books as $book) {
            $status = $book["isGiven"] ? "Given" : "Available";
            echo str_pad($book["id"], 5)
               . str_pad($book["title"], 25)
               . str_pad($book["author"], 20)
               . str_pad($book["price"] . " T", 12)
               . $status . PHP_EOL;
        }
        echo PHP_EOL;
    }
}
