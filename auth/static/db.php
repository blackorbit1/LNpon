<?php

$TESTS = false;

if($TESTS){
    $db_type = 'mysql';
    $host = 'localhost';
    $dbname = 'auth_db';
    $username = 'root';
    $password = 'root';
    $port = '8889';
} else {
    $db_type = 'pgsql';
    $host = 'localhost';
    $dbname = 'auth_db';
    $username = 'www-data';
    $password = 'www-data';
    $port = '5432';
}

$dsn = "$db_type:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";
$dbh = null;
try {
    $dbh = new PDO($dsn);
    if($dbh) {
        echo "Connecté à $dbname avec succès!";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>