<?php

use LibrarySystem\Book;
use LibrarySystem\Customer;
use LibrarySystem\Library;

require_once  __DIR__."/Auto_load/Auto_loader_Main.php";


// Create books
$book1 = new Book("Clean Code", "Robert C. Martin", 45.99);
$book2 = new Book("Design Patterns", "Erich Gamma", 54.50);
$book3 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 12.99);
$book4 = new Book("A Brief History of Time", "Stephen Hawking", 18.75);
$book5 = new Book("The Pragmatic Programmer", "Andrew Hunt", 42.00);
$book6 = new Book("Introduction to Algorithms", "Thomas H. Cormen", 89.99);

$library = new Library();
$library->addBook($book1);
$library->addBook($book2);
$library->addBook($book3);
$library->addBook($book4);
$library->addBook($book5);
$library->addBook($book6);

echo "Book list after adding:\n";
$library->getBooks();
echo "Total books: " . $library->getCountBooks() . "\n\n";

// Remove a book
$library->removeBook("The Great Gatsby");
echo "After removing The Great Gatsby:\n";
$library->getBooks();
echo "Total books: " . $library->getCountBooks() . "\n\n";

// Register customers
$customer1 = new Customer("hadi");
$customer2 = new Customer("hesam");
$customer3 = new Customer("mohammad");

$customer1->addPersonToLibrary();
$customer2->addPersonToLibrary();
$customer3->addPersonToLibrary();

echo "Customers registered: hadi, hesam, mohammad\n\n";

// Borrowing books
echo "Borrowing books:\n";

try {
    $customer1->borrowBookByTitle("Clean Code");
    $customer1->borrowBookByTitle("Design Patterns");
    echo "hadi borrowed Clean Code and Design Patterns\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $customer2->borrowBookByTitle("The Pragmatic Programmer");
    echo "hesam borrowed The Pragmatic Programmer\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $customer3->borrowBookByTitle("Introduction to Algorithms");
    echo "mohammad borrowed Introduction to Algorithms\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $customer3->borrowBookByTitle("Clean Code");
    echo "mohammad borrowed Clean Code (should fail)\n";
} catch (BookAlreadyGivenException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nLibrary status after borrowings:\n";
$library->getBooks();

// Returning books
echo "\nReturning books:\n";

try {
    $customer1->returnBookByTitle("Clean Code");
    echo "hadi returned Clean Code\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $customer2->returnBookByTitle("The Pragmatic Programmer");
    echo "hesam returned The Pragmatic Programmer\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $customer3->returnBookByTitle("Design Patterns");
    echo "mohammad returned Design Patterns (should fail)\n";
} catch (BookNotGivenException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nLibrary status after returns:\n";
$library->getBooks();

// Error test: returning already returned book
echo "\nError test - returning already returned book:\n";
try {
    $customer1->returnBookByTitle("Clean Code");
    echo "hadi returned Clean Code again (should fail)\n";
} catch (BookNotGivenException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Error test: borrowing  book that is not exits in library
echo "\nError test - borrowing non-existent book:\n";
try {
    $customer1->borrowBookByTitle("Non-existent Book");
    echo "hadi borrowed Non-existent Book (should fail)\n";
} catch (BookNotFoundException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Final report
echo "\nFinal library report:\n";
$library->getBooks();
echo "Total books: " . $library->getCountBooks() . "\n";