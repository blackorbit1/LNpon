<?php

require_once 'db.php';

$res = null;
if (isset($_POST['add'])
    && isset($_POST['nature'])
    && isset($_POST['texte'])
    && isset($_POST['id_user'])) {

    $stmt = $dbh->prepare('INSERT INTO posts (nature, texte, date_ajout, id_user) VALUES (:nature, :texte, NOW(), :id_user)');
    $stmt->bindParam(':nature', $_POST['nature'], PDO::PARAM_INT);
    $stmt->bindParam(':texte', $_POST['texte'], PDO::PARAM_STR);
    $stmt->bindParam(':id_user', $_POST['id_user'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = $stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo());

} else if (isset($_POST['remove'])
    && isset($_POST['id_post'])) {

    $stmt = $dbh->prepare('UPDATE posts SET deleted = true WHERE id = ?');
    $stmt->bindParam(1, $_POST['id_post'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = $stmt->execute();

} else if (isset($_GET['get']) // Pour reccuperer 1 post en particulier
&& isset($_GET['id_post'])) {

    $stmt = $dbh->prepare('SELECT * FROM posts WHERE id_post = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['id_post'], PDO::PARAM_INT);

    if($stmt->execute()){ // si la requete a marché
        $result = array();
        $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        
        $result["nature"] = $tmp["nature"];
        $result["texte"] = $tmp["texte"];
        $result["date_ajout"] = $tmp["date_ajout"];
        $result["id_user"] = $tmp["id_user"];
        $result["likes"] = $tmp["likes"];

        $res = json_encode($result);
    }
} else if (isset($_GET['get']) // Pour reccuperer tous les posts d'un user
&& isset($_GET['id_user'])) {

    $stmt = $dbh->prepare('SELECT * FROM posts WHERE id_user = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['id_user'], PDO::PARAM_INT);

    if($stmt->execute()){ // si la requete a marché
        $result = array();

        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            $result[$tmp["id"]] = array();
            $result[$tmp["id"]]["id_post"] = $tmp["id"];
            $result[$tmp["id"]]["nature"] = $tmp["nature"];
            $result[$tmp["id"]]["texte"] = $tmp["texte"];
            $result[$tmp["id"]]["date_ajout"] = $tmp["date_ajout"];
            $result[$tmp["id"]]["likes"] = $tmp["likes"];
        }
        $res = json_encode($result);
    } else {
        $res = "ERREUR SQL";
    }
} else if (isset($_GET['get'])) { // Pour reccuperer tous les posts non supprimés de la BDD

    $stmt = $dbh->prepare('SELECT * FROM posts WHERE deleted = false');
    $stmt->bindParam(1, $_GET['id_user'], PDO::PARAM_INT);

    if($stmt->execute()){ // si la requete a marché
        $result = array();
        
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            $result[$tmp["id"]] = array();
            $result[$tmp["id"]]["nature"] = $tmp["nature"];
            $result[$tmp["id"]]["texte"] = $tmp["texte"];
            $result[$tmp["id"]]["date_ajout"] = $tmp["date_ajout"];
            $result[$tmp["id"]]["id_user"] = $tmp["id_user"];
            $result[$tmp["id"]]["likes"] = $tmp["likes"];
        }
        $res = json_encode($result);
    } else {
        $res = "ERREUR SQL";
    }
} else {
    $res = "AUCUNE ACTION DISPONIBLE POUR CETTE REQUETE";
}
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Index</title>
</head>
<body>
    <?php echo $res ?>
</body>
</html>