<?php

$host = 'localhost';
$dbname = 'user_db';
$username = 'www-data';
$password = 'www-data';
 
$dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$username;password=$password";

$dbh = null;
try {
    $dbh = new PDO($dsn);
    if($dbh) {
        echo "Connecté à $dbname avec succès!";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

$res = null;
if (isset($_POST['create'])
    && isset($_POST['pseudo'])
    && isset($_POST['mdp'])
    && isset($_POST['mail'])) {

    $stmt = $dbh->prepare('INSERT INTO users (pseudo, mdp, mail) VALUES (?, ?, ?)');
    $stmt->bindParam(1, $_POST['p&seudo'], PDO::PARAM_STR, 100);
    $stmt->bindParam(2, password_hash($_POST['mdp'], PASSWORD_ARGON2ID), PDO::PARAM_STR);
    $stmt->bindParam(3, $_POST['mail'], PDO::PARAM_STR);
    $res = $stmt->execute();
}
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Index</title>
</head>
<body>
    <? $res ?>
</body>
</html>