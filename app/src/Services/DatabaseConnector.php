<?php

namespace Services;

class DatabaseConnector
{
    static function getConnection() : \Doctrine\DBAL\Connection {
        $connectionParams = [
            'url' => 'mysql://' . DB_USER . ':' . DB_PASS . '@' . DB_HOST . '/' . DB_NAME
        ];

        try {
            $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
            $connection->connect();
        } catch (\Doctrine\DBAL\Exception $e) {
            echo($e->getMessage() . PHP_EOL);
            exit();
        }
        return $connection;
    }

    public static function handleError($message) {

        if (DEBUG) {
            echo($message . PHP_EOL);
            exit();
        }
        
        $file = fopen(__DIR__ . '/../../storage/db.log', 'a');
        $text = date('Y-m-d H:i:s') . ' ' . $message . PHP_EOL;
        
        error_log($text, 3, $file);
        
        header('Location: /takenlijst/error.html');
        
        exit();
        
    }

}

