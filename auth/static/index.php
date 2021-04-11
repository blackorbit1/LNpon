<?php

require_once 'db.php';

if (isset($_POST['action'])
    && $_POST['action'] == 'login'
    && !empty($_POST['pseudo'])
    && !empty($_POST['password'])) {

    $fields = [
        'action'    => 'login',
        'pseudo'    => $_POST['pseudo'],
        'password'  => $_POST['password']
    ];

    $curl = curl_init('users_nginx:8088');

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($result);

    if ($data->{'status'} === true) {
        $token = bin2hex(random_bytes(32));
        $stmt = $dbh->prepare('INSERT INTO auth (id_user, token) VALUES(?, ?)');
        $stmt->execute([$data->{'id_user'}, $token]);

        $output = ['status' => true, 'id_user' => $data->{'id_user'}, 'pseudo' => $data->{'pseudo'}, 'email' => $data->{'email'}, 'token' => $token];
    }
    else {
        $output = ['status' => false];
    }
}
else if (isset($_POST['action'])
        && $_POST['action'] == 'logout'
        && !empty($_POST['pseudo'])) {

        $stmt = $dbh->prepare('DELETE FROM auth WHERE pseudo = ?');
        $stmt->execute([$_POST['pseudo']]);

    $output = ['status' => true];
}

header('Content-Type: application/json');
echo json_encode($output);

?>
