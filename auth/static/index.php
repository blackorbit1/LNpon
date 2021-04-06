<?php

require_once 'db.php';


$res = 'ok';
/*
if (isset($_POST['create'])
    && isset($_POST['pseudo'])
    && isset($_POST['mdp'])
    && isset($_POST['mail'])) {

    $password = password_hash($_POST['mdp'], PASSWORD_ARGON2ID);

    $stmt = $dbh->prepare('INSERT INTO auth (pseudo, mdp, mail) VALUES (?, ?, ?)');
    $stmt->bindParam(1, $_POST['pseudo'], PDO::PARAM_STR, 100);
    $stmt->bindParam(2, $password, PDO::PARAM_STR);
    $stmt->bindParam(3, $_POST['mail'], PDO::PARAM_STR);
    $res = $stmt->execute();
}
?>
*/



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
