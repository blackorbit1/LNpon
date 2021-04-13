<?php

require_once 'db.php';

$res = null;

if (isset($_POST['add'])
    && isset($_POST['nature'])
    && isset($_POST['id_user_a'])
    && isset($_POST['id_user_b'])) {

    $stmt = $dbh->prepare('INSERT INTO relations (nature, id_user_a, id_user_b) VALUES (:nature, :id_user_a, :id_user_b)');
    $stmt->bindParam(':nature', $_POST['nature'], PDO::PARAM_INT);
    $stmt->bindParam(':id_user_a', $_POST['id_user_a'], PDO::PARAM_INT);
    $stmt->bindParam(':id_user_b', $_POST['id_user_b'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));

} else if (isset($_POST['remove'])
    && isset($_POST['id_relation'])) {

    $stmt = $dbh->prepare('UPDATE relations SET is_deleted = true WHERE id = ?');
    $stmt->bindParam(1, $_POST['id_relation'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = $stmt->execute();

} else if (isset($_POST['remove'])
    && isset($_POST['id_user_a'])
    && isset($_POST['id_user_b'])
    && isset($_POST['nature'])) {

    $stmt = $dbh->prepare('UPDATE relations SET is_deleted = true WHERE nature = ? AND id_user_a = ? AND id_user_b = ?');
    $stmt->bindParam(1, $_POST['nature'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_POST['id_user_a'], PDO::PARAM_INT);
    $stmt->bindParam(3, $_POST['id_user_b'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = $stmt->execute();

} else if (isset($_POST['remove'])
    && isset($_POST['id_relation'])) {

    $stmt = $dbh->prepare('UPDATE relations SET is_deleted = true WHERE id = ?');
    $stmt->bindParam(1, $_POST['id_relation'], PDO::PARAM_INT);

    // retourne true if success, false sinon
    $res = $stmt->execute();

} else if (isset($_GET['get']) // Pour reccuperer 1 relation en particulier
&& isset($_GET['id_relation'])) {

    $stmt = $dbh->prepare('SELECT * FROM relations WHERE id = ? AND is_deleted = false');
    $stmt->bindParam(1, $_GET['id_relation'], PDO::PARAM_INT);

    if($stmt->execute()){ // si la requete a marché
        $result = array();
        $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        if($tmp != null){
            $result["nature"] = $tmp["nature"];
            $result["id_user_a"] = $tmp["id_user_a"];
            $result["id_user_b"] = $tmp["id_user_b"];
        }
        $res = json_encode($result);
    }
} else if (isset($_GET['get']) // Pour reccuperer toutes les relations d'un user
&& isset($_GET['id_user'])) {

    $stmt = $dbh->prepare('SELECT * FROM relations WHERE (id_user_a = ? OR id_user_b = ?) AND is_deleted = false');
    $stmt->bindParam(1, $_GET['id_user'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_GET['id_user'], PDO::PARAM_INT);

    if($stmt->execute()){ // si la requete a marché
        $result = array();

        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            $result[$tmp["id"]] = array();
            $result[$tmp["id"]]["id"] = $tmp["id"];
            $result[$tmp["id"]]["nature"] = $tmp["nature"];
            $result[$tmp["id"]]["id_user_a"] = $tmp["id_user_a"];
            $result[$tmp["id"]]["id_user_b"] = $tmp["id_user_b"];
        }
        $res = json_encode($result);
    } else {
        $res = "ERREUR SQL";
    }
} else if (isset($_GET['get'])) { // Pour reccuperer tous les posts non supprimés de la BDD

    $stmt = $dbh->prepare('SELECT * FROM relations WHERE is_deleted = false');

    if($stmt->execute()){ // si la requete a marché
        $result = array();

        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            $result[$tmp["id"]] = array();
            $result[$tmp["id"]]["nature"] = $tmp["nature"];
            $result[$tmp["id"]]["text_content"] = $tmp["text_content"];
            $result[$tmp["id"]]["created_at"] = $tmp["created_at"];
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

<?php echo $res ?>
