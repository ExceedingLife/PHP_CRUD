<?php
// mySQL database connection data.
define("DB_Server", "localhost");
define("DB_Username", "root");
define("DB_Password", "password");
define("DB_Name", "cruddb");

/* Attempt to connect to MySQL Database */
try {
    $pdoConnect = new PDO("mysql:host=" . DB_Server . ";dbname=" .
                           DB_Name, DB_Username, DB_Password);
    // Set the PDO error mode to exception.
    //echo "Successfully Connected@!";
} catch (PDOException $e) {
    //echo $e->getMessage();
    die("Error: Could not connect. " . $e->getMessage());
}
