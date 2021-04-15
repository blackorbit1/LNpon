<?php

if (isset($_POST['action'])
    && $_POST['action'] === 'upload_image'
    && !empty($_POST['user_id'])
    && !empty($_POST['nature'])) {

    if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], "/var/www/uploads/$_FILES['userfile']['name']")) {
            $stmt = $dbh->prepare('INSERT INTO images (user_id, chemin, nature) VALUES (?, ?)');
            $res = $stmt->execute([$_POST['user_id'], "/var/www/uploads/$name", $_POST['nature']]);

            if ($res) {
                $output = ['status' => true, 'filename' => $_FILES['userfile']['name'], 'user_id' => $_POST['user_id']];
            }
            else {
                $output = ['status' => false];
            }
        else {
            $output = ['status' => false];
        }
    }

    $output = ['status' => false];
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
