<?php

require_once 'db.php';

if (isset($_POST['action'])
    && $_POST['action'] == 'login'
    && !empty($_POST['id_user'])
    && !empty($_POST['password'])) {
/*
    $fields = [
        'action'    => 'login',
        'pseudo'    => $_POST['pseudo'],
        'password'  => $_POST['password']
    ];
*/
/*
    $curl = curl_init('users_nginx:8088');

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);
    curl_close($curl);
*/
//    $data = json_decode($result);

        $token = bin2hex(random_bytes(32));
        $stmt = $dbh->prepare('INSERT INTO auth (id_user, token) VALUES(?, ?)');
        $stmt->execute([$_POST['id_user'], "$token"]);

        $output = ['status' => true, 'id_user' => $_POST['id_user'], 'token' => $token];
}
else if (isset($_POST['action'])
        && $_POST['action'] == 'logout'
        && !empty($_POST['id_user'])) {

        $stmt = $dbh->prepare('DELETE FROM auth WHERE id_user = ?');
        $stmt->execute([$_POST['id_user']]);

    $output = ['status' => true];
}

header('Content-Type: application/json');
echo json_encode($output);

?>
