<?php
$output = ['status' => false];
if (isset($_POST['action'])
    && $_POST['action'] == 'upload_image'
    && !empty($_POST['user_id'])
    && isset($_POST['nature'])) {

    if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
        $filename = basename($_FILES['avatar']['name']);

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], "/var/www/uploads/$filename")) {
            $stmt = $dbh->prepare('INSERT INTO images (image_id, user_id, nature) OUTPUT INSERTED.image_id VALUES (default, ?, ?) RETURNING image_id');
            $res = $stmt->execute([$_POST['user_id'], "/var/www/uploads/$filename", $_POST['nature']]);

            if ($res) {
                $temp = $stmt->fetch(PDO::FETCH_ASSOC);
                $output = [
                    'status' => true,
                    'filename' => $_FILES['userfile']['name'],
                    'user_id' => $_POST['user_id'],
                    'image_id' => $temp['image_id']
                ];
            }
            else {
                $output['message'] = 'error with res';
            }
        }
        else {
            $output['message'] = 'error with move_uploaded_file';
        }
    }
    else {
        $output['message'] = 'error with is_uploaded_file';
    }
}
else if (isset($_POST['action'])
        && $_POST['action'] === 'get_image'
        && !empty($_POST['image_id'])) {

    $stmt = $dbh->prepare('SELECT * FROM images WHERE image_id = ?');

    if ($stmt->execute($_POST['image_id'])) {
        $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
else if (isset($_POST['action'])
        && $_POST['action'] === 'get_image'
        && !empty($_POST['user_id'])) {

    $stmt = $dbh->prepare('SELECT * FROM images WHERE user_id = ?');

    if ($stmt->execute($_POST['user_id'])) {
        $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

header('Content-Type: application/json');
echo json_encode($output);
?>
