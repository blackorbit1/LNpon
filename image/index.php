<?php

$host = 'localhost';
$dbname = 'image_db';
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
    && isset($_POST['user_id'])
    && isset($_POST['chemin'])
    && isset($_POST['nature'])) {

    $stmt = $dbh->prepare('INSERT INTO images (user_id, chemin, nature) VALUES (?, ?)');
    $stmt->bindParam(1, $_POST['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_POST['chemin'], PDO::PARAM_STR, 100);
    $stmt->bindParam(3, $_POST['nature'], PDO::PARAM_INT);
    $res = $stmt->execute();
} else if(isset($_POST['get']) // image by id
    && isset($_POST['id'])) {

    $stmt = $dbh->prepare('SELECT * FROM images WHERE id = ?');

    if($stmt->execute()){ 
        $result = array();
        $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        
        $result['user_id'] = $tmp['user_id'];
        $result['chemin'] = $tmp['chemin'];
        $result['nature'] = $tmp['nature'];

        $res = json_encode($result);
    } else {
        $res = "ERREUR SQL";
    }

} else if(isset($_POST['get']) // images by user
&& isset($_POST['user_id'])) {

    $stmt = $dbh->prepare('SELECT * FROM images WHERE user_id = ?');

    if($stmt->execute()){ 
        $result = array();
        $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        
        $result['user_id'] = $tmp['user_id'];
        $result['chemin'] = $tmp['chemin'];
        $result['nature'] = $tmp['nature'];

        $res = json_encode($result);
    } else {
        $res = "ERREUR SQL";
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