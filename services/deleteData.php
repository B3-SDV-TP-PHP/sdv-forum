<?php
    $db = new PDO('mysql:host=localhost;dbname=sdv_forum', 'root', '');

    function deleteTopic($topic_id)
    {
        global $db;
        try {
            $db->beginTransaction();

            // Delete comments related to the topic
            $stmt = $db->prepare("DELETE FROM comments WHERE topic_id = :topic_id");
            $stmt->execute(['topic_id' => $topic_id]);

            // Delete the topic
            $stmt = $db->prepare("DELETE FROM topics WHERE topic_id = :topic_id");
            $stmt->execute(['topic_id' => $topic_id]);

            $db->commit();
            return $stmt->rowCount();
        } catch (Exception $e) {
            $db->rollBack();
            die('Erreur : ' . $e->getMessage());
        }
    }

    function deleteComment($comment_id)
    {
        global $db;
        try {
            $stmt = $db->prepare("DELETE FROM comments WHERE comment_id = :comment_id");
            $stmt->execute(['comment_id' => $comment_id]);
            return $stmt->rowCount();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    function deleteUser($user_id)
    {
        global $db;
        try {
            $db->beginTransaction();

            // Delete all comments by the user
            $stmt = $db->prepare("DELETE FROM comments WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);

            // Get all topics by the user
            $stmt = $db->prepare("SELECT topic_id FROM topics WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            $topics = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Delete all topics by the user
            foreach ($topics as $topic_id) {
                deleteTopic($topic_id);
            }

            // Delete the user
            $stmt = $db->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);

            $db->commit();
            return $stmt->rowCount();
        } catch (Exception $e) {
            $db->rollBack();
            die('Erreur : ' . $e->getMessage());
        }
    }
?>