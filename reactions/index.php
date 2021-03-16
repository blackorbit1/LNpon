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
if (isset($_POST['add'])
    && isset($_POST['id_post'])
    && isset($_POST['id_user'])
    && isset($_POST['emoji'])) {

    $stmt = $dbh->prepare('INSERT INTO reactions (emoji, id_user, id_post) VALUES (?, ?, ?)');
    $stmt->bindParam(1, $_POST['emoji'], PDO::PARAM_STR, 10);
    $stmt->bindParam(2, $_POST['id_user'], PDO::PARAM_INT);
    $stmt->bindParam(3, $_POST['id_post'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = $stmt->execute();

} else if (isset($_POST['remove'])
    && isset($_POST['id_post'])
    && isset($_POST['id_user'])
    && isset($_POST['emoji'])) {

    $stmt = $dbh->prepare('UPDATE reactions SET deleted = true WHERE emoji = ? AND id_user = ? AND id_post = ?');
    $stmt->bindParam(1, $_POST['emoji'], PDO::PARAM_STR, 10);
    $stmt->bindParam(2, $_POST['id_user'], PDO::PARAM_INT);
    $stmt->bindParam(3, $_POST['id_post'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = $stmt->execute();

} else if (isset($_GET['get'])
&& isset($_GET['id_post'])) {

    $stmt = $dbh->prepare('SELECT emoji, id_user FROM reactions WHERE id_post = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['id_post'], PDO::PARAM_INT);
    //$res = $stmt->execute();

    // retourne un json avec chaque reactions et chaque personne ayant participé à chacune
    if($stmt->execute()){ // si la requete a marché
        $result = array();
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            if(!isset($result[$tmp["emoji"]])) $result[$tmp["emoji"]] = [];
            array_push($result[$tmp["emoji"]], $tmp["id_user"]);
        }
        $res = json_encode($result);
    }
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