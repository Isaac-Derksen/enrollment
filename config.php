<?php
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "Password1");
    define("DB_NAME", "Enrollment");

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn === false) {
        die("Connection Error: ". $conn->connect_error);
    }
?>