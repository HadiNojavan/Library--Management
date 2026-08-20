<?php

namespace LibrarySystem;

abstract class JsonStorage {

    abstract protected static function getFilePath(): string;

    public static function saveData(array $data): void {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(static::getFilePath(), $jsonData);
    }

    public static function loadData(): array {
        $filePath = static::getFilePath();
        if (!file_exists($filePath)) {
            return [];
        }
        $content = file_get_contents($filePath);
        return json_decode($content, true) ?? [];
    }

    protected static function getNextId(): int {
        $items = static::loadData();
        if (empty($items)) {
            return 1;
        }
        $ids = array_column($items, "id");
        return max($ids) + 1;
    }
}
