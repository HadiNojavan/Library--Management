<?php

namespace LibrarySystem;

use LibrarySystem\Exceptions\CustomerNotRegisteredException;
use LibrarySystem\Exceptions\CustomerNotFoundException;
use LibrarySystem\Exceptions\BookNotFoundException;


//require_once __DIR__ . '/Exception.php';
//require_once __DIR__ . '/JsonStorage.php';

class CustomerStorage extends JsonStorage {

    protected static function getFilePath(): string {
        return __DIR__ . '/../data/report_customers.json';
    }

    public static function addCustomer($newCustomer) {
        $id = self::getNextId();
        $newCustomer->setId($id);
        $customers = self::loadData();
        $customers[] = $newCustomer;
        self::saveData($customers);
    }

    public static function removeBorrowedBook($idCustomer, $returnedBook) {
        $idReturnBook = $returnedBook["id"];
        if ($idCustomer === null) {
            throw new CustomerNotRegisteredException("you have to register for library first");
        }

        $customers = self::loadData();
        $customerFound = false;
        $bookFound = false;

        foreach ($customers as $key => $customer) {
            if ($customer["id"] === $idCustomer) {
                $customerFound = true;

                foreach ($customer["borrowedBooks"] as $k => $borrowedbook) {
                    if ($borrowedbook["id"] === $idReturnBook) {
                        unset($customers[$key]["borrowedBooks"][$k]);
                        $customers[$key]["borrowedBooks"] = array_values($customers[$key]["borrowedBooks"]);
                        $bookFound = true;
                        break;
                    }
                }
                break;
            }
        }

        if (!$customerFound) {
            throw new CustomerNotFoundException("customer with id '{$idCustomer}' not found");
        }

        if (!$bookFound) {
            throw new BookNotFoundException("this customer did not borrow book with id '{$idReturnBook}'");
        }

        self::saveData($customers);
    }

    public static function addBorrowedBook($idCustomer, $borrowedBook) {
        if ($idCustomer === null) {
            throw new CustomerNotRegisteredException("you have to register for library first");
        }

        $customers = self::loadData();
        $found = false;

        foreach ($customers as $key => $customer) {
            if ($customer["id"] === $idCustomer) {
                $customers[$key]["borrowedBooks"][] = [
                    "id"    => $borrowedBook["id"],
                    "title" => $borrowedBook["title"]
                ];
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new CustomerNotFoundException("customer with id '{$idCustomer}' not found");
        }

        self::saveData($customers);
    }
}
