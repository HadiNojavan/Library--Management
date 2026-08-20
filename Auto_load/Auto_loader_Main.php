<?php

const BASE_PATH = __DIR__ . '/../';

function base_path($path) {
    return BASE_PATH . $path;
}
spl_autoload_register(function ($class) {

    if (strpos($class, 'LibrarySystem\\Exceptions\\') === 0) {
        $file = base_path("src/Exception.php");
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
    
    $path = str_replace('\\', '/', $class);
    $path = str_replace('LibrarySystem/', '', $path);
    $file = base_path("src/{$path}.php");
    
    if (file_exists($file)) 
        require $file;

    else 
        throw new Exception("Class file not found: {$file}");
    
});

?>