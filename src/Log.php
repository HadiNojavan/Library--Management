<?php

namespace LibrarySystem;

trait Log {
    public function Add_log($message) {
        $logFile = __DIR__ . '/../data/log.txt';
        file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }
}

?>