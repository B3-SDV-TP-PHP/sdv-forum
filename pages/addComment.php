<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=sdv_forum', 'root', '');

    if (isset($_POST['category_id'], $_POST['topic_id'], $_POST['user_id'], $_POST['content'])) {
        $categoryId = (int)$_POST['category_id'];
        $topicId = (int)$_POST['topic_id'];
        $userId = (int)$_POST['user_id'];
        $content = trim($_POST['content']);

        if (!empty($content)) {
            $query = $db->prepare("INSERT INTO comments (topic_id, user_id, content, created_at) 
                                   VALUES (:topicId, :userId, :content, NOW())");
            $query->execute([
                'topicId' => $topicId,
                'userId' => $userId,
                'content' => $content
            ]);

            header("Location: ../pages/index.php?id=$categoryId&subject_id=$topicId");
            exit;
        } else {
            echo "Le contenu du commentaire ne peut pas être vide.";
        }
    } else {
        echo "Informations de commentaire manquantes.";
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
