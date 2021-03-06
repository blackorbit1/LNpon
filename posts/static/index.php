<?php

require_once 'db.php';

$res = null;
if (isset($_POST['add'])
    && isset($_POST['nature'])
    && isset($_POST['text_content'])
    && isset($_POST['id_user'])) {

    $stmt = $dbh->prepare('INSERT INTO posts (nature, text_content, created_at, id_user) VALUES (:nature, :text_content, NOW(), :id_user)');
    $stmt->bindParam(':nature', $_POST['nature'], PDO::PARAM_INT);
    $stmt->bindParam(':text_content', $_POST['text_content'], PDO::PARAM_STR);
    $stmt->bindParam(':id_user', $_POST['id_user'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = ($stmt->execute() ? "succes" : "echec : " . json_encode($stmt->errorInfo()));

} else if (isset($_POST['remove'])
    && isset($_POST['id_post'])) {

    $stmt = $dbh->prepare('UPDATE posts SET is_deleted = true WHERE id = ?');
    $stmt->bindParam(1, $_POST['id_post'], PDO::PARAM_INT);
    // retourne true if success, false sinon
    $res = $stmt->execute();

} else if (isset($_GET['get']) // Pour reccuperer 1 post en particulier
&& isset($_GET['id_post'])) {

    $stmt = $dbh->prepare('SELECT * FROM posts WHERE id = ? AND is_deleted = false');
    $stmt->bindParam(1, $_GET['id_post'], PDO::PARAM_INT);

    if($stmt->execute()){ // si la requete a marché
        $result = array();
        $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

        $result["nature"] = $tmp["nature"];
        $result["text_content"] = $tmp["text_content"];
        $result["created_at"] = $tmp["created_at"];
        $result["id_user"] = $tmp["id_user"];
        $result["likes"] = $tmp["likes"];

        $res = json_encode($result);
    }
} else if (isset($_GET['get']) // Pour reccuperer tous les posts d'un user
&& isset($_GET['id_user'])) {

    $stmt = $dbh->prepare('SELECT * FROM posts WHERE id_user = ? AND is_deleted = false');
    $stmt->bindParam(1, $_GET['id_user'], PDO::PARAM_INT);

    if($stmt->execute()){ // si la requete a marché
        $result = array();

        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $tmp){
            $result[$tmp["id"]] = array();
            $result[$tmp["id"]]["id_post"] = $tmp["id"];
            $result[$tmp["id"]]["nature"] = $tmp["nature"];
            $result[$tmp["id"]]["text_content"] = $tmp["text_content"];
            $result[$tmp["id"]]["created_at"] = $tmp["created_at"];
            $result[$tmp["id"]]["likes"] = $tmp["likes"];
        }
        $res = json_encode($result);
    } else {
        $res = "ERREUR SQL";
    }
} else if (isset($_GET['get'])) { // Pour reccuperer tous les posts non supprimés de la BDD

    $stmt = $dbh->prepare('SELECT * FROM posts WHERE is_deleted = false');

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
