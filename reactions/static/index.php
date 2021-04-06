<?php

require_once 'db.php';

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
    $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));

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
    } else {
        $res = "echec : " . json_encode($stmt->errorInfo());
    }
}
?>


<? echo $res ?>


<?php

/*
 * // On vérifie si la reaction en question n'existe pas
    $stmt = $dbh->prepare('SELECT count(emoji) as cnt FROM reactions WHERE emoji = ? AND id_post = ?');
    $stmt->bindParam(1, $_GET['emoji'], PDO::PARAM_STR);
    $stmt->bindParam(2, $_GET['id_post'], PDO::PARAM_INT);

    if($stmt->execute()){ // si la requete a marché
        if(1 == $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["cnt"]){
            $stmt = $dbh->prepare('UPDATE reactions SET deleted = false AND  WHERE emoji = ? AND id_user = ? AND id_post = ?');
            $stmt->bindParam(1, $_POST['emoji'], PDO::PARAM_STR, 10);
            $stmt->bindParam(2, $_POST['id_user'], PDO::PARAM_INT);
            $stmt->bindParam(3, $_POST['id_post'], PDO::PARAM_INT);
            // retourne true if success, false sinon
            $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));
        } else {
            $stmt = $dbh->prepare('INSERT INTO reactions (emoji, id_user, id_post) VALUES (?, ?, ?)');
            $stmt->bindParam(1, $_POST['emoji'], PDO::PARAM_STR, 10);
            $stmt->bindParam(2, $_POST['id_user'], PDO::PARAM_INT);
            $stmt->bindParam(3, $_POST['id_post'], PDO::PARAM_INT);
            // retourne true if success, false sinon
            $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));
        }

    }
 */
?>