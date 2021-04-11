<?php

require_once 'db.php';

$res = null;


// ENTITE GROUPE
if (isset($_POST['create'])
    && isset($_POST['admin_id'])
    && isset($_POST['group_name'])) {

    $stmt = $dbh->prepare('INSERT INTO groupes (admin_id, group_name) VALUES (?, ?)');
    $stmt->bindParam(1, $_POST['admin_id'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_POST['group_name'], PDO::PARAM_STR);
    // retourne true if success, false sinon
    $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));

} else if (isset($_POST['delete'])
    && isset($_POST['id_groupe'])) {

    $stmt = $dbh->prepare('UPDATE groupes SET deleted = true WHERE id = ?');
    $stmt->bindParam(1, $_POST['id_groupe'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = $stmt->execute();

} else if (isset($_GET['get']) // Tous les groupes d'un admin
    && isset($_GET['admin_id'])) {

    $stmt = $dbh->prepare('SELECT * FROM groupes WHERE admin_id = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['admin_id'], PDO::PARAM_INT);
    //$res = $stmt->execute();

    // retourne un json avec chaque reactions et chaque personne ayant participé à chacune
    if($stmt->execute()){ // si la requete a marché
        $result = array();
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            $groupe = array();
            $groupe["id"] = $tmp["id"];
            $groupe["group_name"] = $tmp["group_name"];
            $groupe["admin_id"] = $tmp["admin_id"];
            array_push($result, $groupe);
        }
        $res = json_encode($result);
    } else {
        $res = "echec : " . json_encode($stmt->errorInfo());
    }
} else if (isset($_GET['get']) // Un groupe en particulier
    && isset($_GET['id_groupe'])) {

    $stmt = $dbh->prepare('SELECT * FROM groupes WHERE id = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['id_groupe'], PDO::PARAM_INT);
    //$res = $stmt->execute();

    // retourne un json avec chaque reactions et chaque personne ayant participé à chacune
    if($stmt->execute()){ // si la requete a marché
        $tmp = $stmt->fetch(PDO::FETCH_ASSOC);
        $result = array();
        $result["id"] = $tmp["id"];
        $result["group_name"] = $tmp["group_name"];
        $result["admin_id"] = $tmp["admin_id"];

        $res = json_encode($result);
    } else {
        $res = "echec : " . json_encode($stmt->errorInfo());
    }
}




// MEMBRES GROUPE
if (isset($_POST['add'])
    && isset($_POST['user_id'])
    && isset($_POST['group_id'])) {

    $stmt = $dbh->prepare('INSERT INTO groupes_members (user_id, group_id) VALUES (?, ?)');
    $stmt->bindParam(1, $_POST['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_POST['group_id'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));

} else if (isset($_POST['remove'])
    && isset($_POST['user_id'])
    && isset($_POST['group_id'])) {

    $stmt = $dbh->prepare('DELETE FROM groupes_members WHERE user_id = ? AND group_id = ?');
    $stmt->bindParam(1, $_POST['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_POST['group_id'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));

} else if (isset($_GET['get']) // Get tous les groupes d'un user
    && isset($_GET['user_id'])) {

    $stmt = $dbh->prepare('SELECT group_id FROM groupes_members WHERE user_id = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['user_id'], PDO::PARAM_INT);
    //$res = $stmt->execute();

    // retourne un json avec chaque reactions et chaque personne ayant participé à chacune
    if($stmt->execute()){ // si la requete a marché
        $result = array();
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            array_push($result, $tmp["group_id"]);
        }
        $res = json_encode($result);
    } else {
        $res = "echec : " . json_encode($stmt->errorInfo());
    }
} else if (isset($_GET['get']) // Get tous les users d'un groupe
    && isset($_GET['users'])
    && isset($_GET['group_id'])) {

    $stmt = $dbh->prepare('SELECT user_id FROM groupes_members WHERE group_id = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['group_id'], PDO::PARAM_INT);
    //$res = $stmt->execute();

    // retourne un json avec chaque reactions et chaque personne ayant participé à chacune
    if($stmt->execute()){ // si la requete a marché
        $result = array();
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            array_push($result, $tmp["user_id"]);
        }
        $res = json_encode($result);
    } else {
        $res = "echec : " . json_encode($stmt->errorInfo());
    }
}




// POSTS GROUPE
if (isset($_POST['add'])
    && isset($_POST['post_id'])
    && isset($_POST['group_id'])) {

    $stmt = $dbh->prepare('INSERT INTO groupes_posts (post_id, group_id) VALUES (?, ?)');
    $stmt->bindParam(1, $_POST['post_id'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_POST['group_id'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));

} else if (isset($_POST['remove'])
    && isset($_POST['post_id'])
    && isset($_POST['group_id'])) {

    $stmt = $dbh->prepare('DELETE FROM groupes_posts WHERE post_id = ? AND group_id = ?');
    $stmt->bindParam(1, $_POST['post_id'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_POST['group_id'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));

} else if (isset($_GET['get']) // Get tous les groupes d'un post
    && isset($_GET['post_id'])) {

    $stmt = $dbh->prepare('SELECT group_id FROM groupes_posts WHERE post_id = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['post_id'], PDO::PARAM_INT);
    //$res = $stmt->execute();

    // retourne un json avec chaque reactions et chaque personne ayant participé à chacune
    if($stmt->execute()){ // si la requete a marché
        $result = array();
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            array_push($result, $tmp["group_id"]);
        }
        $res = json_encode($result);
    } else {
        $res = "echec : " . json_encode($stmt->errorInfo());
    }
} else if (isset($_GET['get']) // Get tous les posts d'un groupe
    && isset($_GET['posts'])
    && isset($_GET['group_id'])) {

    $stmt = $dbh->prepare('SELECT post_id FROM groupes_posts WHERE group_id = ? AND deleted = false');
    $stmt->bindParam(1, $_GET['group_id'], PDO::PARAM_INT);
    //$res = $stmt->execute();

    // retourne un json avec chaque reactions et chaque personne ayant participé à chacune
    if($stmt->execute()){ // si la requete a marché
        $result = array();
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            array_push($result, $tmp["post_id"]);
        }
        $res = json_encode($result);
    } else {
        $res = "echec : " . json_encode($stmt->errorInfo());
    }
}
?>


<? echo $res ?>