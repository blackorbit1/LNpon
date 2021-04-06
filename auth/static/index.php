<?php

require_once 'db.php';


if (isset($_POST['login'])
    && !empty($_POST['pseudo'])
    && !empty($_POST['password'])) {

    curl("users_nginx:8088/verify_user?pseudo=$_POST['pseudo']&password=$_POST['password']");

    // TODO test curl return -> if true then generate token
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Index</title>
</head>
<body>
</body>
</html>
