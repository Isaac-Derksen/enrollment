<?php
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "Password1");
    define("DB_NAME", "Testing");

    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($connection === false) {
        die("ERROR: Could not connect. ". $connection->connection_error);
    }
?>