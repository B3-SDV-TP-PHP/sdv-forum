<?php
require_once '../services/deleteData.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic_id = $_POST['topic_id'];
    $user_id = $_POST['user_id'];

    if (isset($topic_id) && isset($user_id)) {
        $deleted = deleteTopic($topic_id);
        if ($deleted) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Erreur lors de la suppression du sujet.";
        }
    } else {
        echo "ID du sujet non spécifié.";
    }
} else {
    echo "Requête invalide.";
}
?>  