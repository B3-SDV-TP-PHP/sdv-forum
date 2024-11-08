<?php
require_once '../services/deleteData.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];

    if (isset($comment_id) && isset($user_id)) {
        $deleted = deleteComment($comment_id);
        if ($deleted) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Erreur lors de la suppression du commentaire.";
        }
    } else {
        echo "ID du commentaire non spécifié.";
    }
} else {
    echo "Requête invalide.";
}
?>