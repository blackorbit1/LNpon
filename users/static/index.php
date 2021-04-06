<?php

require_once 'db.php';


if (isset($_POST['create'])
    && !empty($_POST['pseudo'])
    && !empty($_POST['password'])
    && !empty($_POST['email'])) {

    $pseudo = $_POST['pseudo'];
    $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);
    $email = $_POST['email'];

    $stmt = $dbh->prepare('INSERT INTO users (pseudo, password, email) VALUES (?, ?, ?)');
    $res = $stmt->execute([$pseudo, $password, $email]);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Index</title>
</head>
<body>
    <?= $res ?>
</body>
</html>
