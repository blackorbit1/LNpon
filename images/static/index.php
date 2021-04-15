<?php

if (isset($_POST['create']) // TODO : il faut aussi surement gerer la recupération d'un fichier
    && isset($_POST['user_id'])
    && isset($_POST['chemin'])
    && isset($_POST['nature'])) {

    $stmt = $dbh->prepare('INSERT INTO images (user_id, chemin, nature) VALUES (?, ?)');
    $stmt->bindParam(1, $_POST['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(2, $_POST['chemin'], PDO::PARAM_STR, 100);
    $stmt->bindParam(3, $_POST['nature'], PDO::PARAM_INT);
    $res = $stmt->execute();
}
else if (isset($_POST['action'])
        && $_POST['action'] === 'get_image'
        && !empty($_POST['image_id'])) {

    $stmt = $dbh->prepare('SELECT * FROM images WHERE image_id = ?');

    if ($stmt->execute($_POST['image_id'])) {
        $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        $output = ['status' => false];
    }
}
else if (isset($_POST['action'])
        && $_POST['action'] === 'get_image'
        && !empty($_POST['user_id'])) {

    $stmt = $dbh->prepare('SELECT * FROM images WHERE user_id = ?');

    if ($stmt->execute($_POST['user_id'])) {
        $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        $output = ['status' => false];
    }
}

header('Content-Type: application/json');
echo json_encode($output);
?>
