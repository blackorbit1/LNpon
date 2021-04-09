<?php

require_once 'db.php';


if (isset($_POST['action'])
    && $_POST['action'] == 'create'
    && !empty($_POST['pseudo'])
    && !empty($_POST['password'])
    && !empty($_POST['email'])) {

    $pseudo = $_POST['pseudo'];
    $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);
    $email = $_POST['email'];

    $stmt = $dbh->prepare('INSERT INTO users (pseudo, password, email) VALUES (?, ?, ?)');
    $res = $stmt->execute([$pseudo, $password, $email]);

    $output = ['result' => $res ? true : false];
}
else if (isset($_POST['action'])
         && $_POST['action'] == 'login'
         && !empty($_POST['pseudo'])
         && !empty($_POST['password'])) {

    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    $stmt = $dbh->prepare('SELECT * FROM users WHERE pseudo = ?');
    $res = $stmt->execute([$pseudo]);

    if ($res && $stmt->rowCount()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $password_valid = password_verify($password, $row['password']);

        $output = ['result' => true, 'id_user' => $row['id_user'], 'pseudo' => $row['pseudo'], 'email' => $row['email']];
    }
    else {
        $output = ['result' => false];
    }
}

header('Content-Type: application/json');
echo json_encode($output);

?>
