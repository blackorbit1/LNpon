<?php

require_once 'db.php';

if (isset($_POST['login'])
    && !empty($_POST['pseudo'])
    && !empty($_POST['password'])) {

    $res = file_get_contents("users_nginx:8088?action=login&pseudo=$_POST['pseudo']&password=$_POST['password']");
    $data = json_decode($res);

    if ($data->{'status'} == 'success') {
        $stmt = $dbh->prepare('INSERT INTO auth (id_user, token) VALUES(?, ?)');
        $stmt->execute([$data->{'id_user'}, bin2hex(random_bytes(32))]);
    }

}
else if (isset($_POST['action']
        && $_POST['action'] == 'logout'
        && !empty($_POST['pseudo'])) {

}

?>
