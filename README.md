# 📚 Library Management System

A simple yet powerful **Library Management System** built with **Pure PHP (Object-Oriented)**.
This project is designed as a practical exercise to demonstrate core OOP concepts, file-based data storage using JSON, and custom autoloading — all without using any databases or external frameworks.

---

## ✨ Features

- **Manage Books** – Add, remove, and list books.
- **Manage Customers** – Register customers and track borrowed books.
- **Borrow & Return** – Borrow books by title or ID, and return them.
- **Data Persistence** – All data is stored in JSON files (no database required).
- **Logging System** – Every action is logged to `data/log.txt` using a custom `Log` trait.
- **Custom Autoloader** – A PSR-4-like autoloader handles all class loading.
- **Exception Handling** – Custom exceptions for different error scenarios.
- **Object-Oriented Design** – Demonstrates:
  - Classes & Objects
  - Encapsulation (private properties, getters/setters)
  - Inheritance (`LibraryStorage`, `CustomerStorage` extend `JsonStorage`)
  - Abstract Classes (`JsonStorage`)
  - Interfaces (`JsonSerializable`)
  - Traits (`Log`)
  - Namespaces (`LibrarySystem`, `LibrarySystem\Exceptions`)

---

## 🛠️ Technologies Used

- **PHP 7.4+**
- **JSON** – for data storage
- **Custom Autoloader** – no Composer required (though you can easily switch to Composer)

---

## 📁 Project Structure

```
project-root/
├── Auto_load/
│   └── Auto_loader_Main.php      # Custom autoloader
├── data/
│   ├── log.txt                   # System logs
│   ├── report_customers.json     # Customer data storage
│   └── report_Library.json       # Book data storage
├── src/
│   ├── Book.php                  # Book class
│   ├── Customer.php              # Customer class
│   ├── CustomerStorage.php       # Customer storage (extends JsonStorage)
│   ├── Exception.php             # Custom exceptions
│   ├── JsonStorage.php           # Abstract JSON storage class
│   ├── Library.php               # Library logic (add/remove books)
│   ├── LibraryStorage.php        # Book storage (extends JsonStorage)
│   └── Log.php                   # Logging trait
├── Main.php                      # Entry point (runs the program)
└── README.md                     # This file
```

---

## 🚀 Getting Started

### Prerequisites

- PHP 7.4 or higher installed on your machine.
- A terminal / command line.

### Installation

1. **Clone the repository** (or download the source code):
   ```bash
   git clone https://github.com/HadiNojavan/Library--Management.git
   cd Library--Management
   ```

2. No additional setup is required! All dependencies are pure PHP.

3. Ensure the `data/` directory has write permissions so the JSON files and log can be created/updated:
   ```bash
   chmod -R 775 data/
   ```

### Running the Application

Simply execute the `Main.php` script from the project root:

```bash
php Main.php
```

This will:

- Create 6 sample books.
- Remove one book.
- Register three customers (`hadi`, `hesam`, `mohammad`).
- Simulate borrowing and returning books with proper error handling.
- Display the current state of the library and customer borrow lists.

---

## 🧪 Sample Output

When you run `php Main.php`, you'll see something like this:

```
Book list after adding:
ID   Title                    Author              Price       Status
-----------------------------------------------------------------
1    Clean Code               Robert C. Martin    45.99 T     Available
2    Design Patterns          Erich Gamma         54.5 T      Available
3    The Great Gatsby         F. Scott Fitzgerald 12.99 T     Available
4    A Brief History of Time  Stephen Hawking     18.75 T     Available
5    The Pragmatic Programmer Andrew Hunt         42 T        Available
6    Introduction to Algorithms Thomas H. Cormen  89.99 T     Available

Total books: 6

After removing The Great Gatsby:
ID   Title                    Author              Price       Status
-----------------------------------------------------------------
1    Clean Code               Robert C. Martin    45.99 T     Available
2    Design Patterns          Erich Gamma         54.5 T      Available
4    A Brief History of Time  Stephen Hawking     18.75 T     Available
5    The Pragmatic Programmer Andrew Hunt         42 T        Available
6    Introduction to Algorithms Thomas H. Cormen  89.99 T     Available

Total books: 5

Borrowing books:
hadi borrowed Clean Code and Design Patterns
hesam borrowed The Pragmatic Programmer
mohammad borrowed Introduction to Algorithms
Error: book with title 'Clean Code' is already given

Returning books:
hadi returned Clean Code
hesam returned The Pragmatic Programmer
Error: this customer did not borrow book with id '2'

Final library report:
...
```

All actions are also logged to `data/log.txt`.

---

## 📖 How It Works

### Core Components

- **`Book`** – Represents a book with properties like `id`, `title`, `author`, `price`, and `isGiven`.
- **`Customer`** – Represents a user who can borrow and return books.
- **`Library`** – Handles high-level operations like adding/removing books.
- **Storage Classes (`LibraryStorage`, `CustomerStorage`)** – Extend `JsonStorage` to handle reading/writing JSON files.
- **`JsonStorage`** (abstract) – Provides common methods for JSON file operations (`saveData`, `loadData`, `getNextId`).
- **`Log` trait** – Adds logging capability to any class (used in `Book`, `Library`, `Customer`).
- **Custom Exceptions** – Extend PHP's built-in `Exception` class for specific errors.

### Autoloading

The custom autoloader (`Auto_loader_Main.php`) automatically loads classes based on their namespace and class name:

- Classes in `LibrarySystem\Exceptions` – loaded from `src/Exception.php`.
- All other `LibrarySystem` classes – loaded from `src/{ClassName}.php`.