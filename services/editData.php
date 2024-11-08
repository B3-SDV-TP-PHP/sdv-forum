<?php
$db = new PDO('mysql:host=localhost;dbname=sdv_forum', 'root', '');

function updateUser($user_id, $username, $email, $password = NULL)
{
    global $db;
    try {
        $request = "UPDATE users SET username = :username, email = :email";
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $request .= ", password = :password";
        }
        $request .= " WHERE user_id = :user_id";
        
        $stmt = $db->prepare($request);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        if ($password) {
            $stmt->bindParam(':password', $hashedPassword);
        }
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        return TRUE;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function updateTopic($topic_id, $title, $category_id)
{
    global $db;
    try {
        $request = "UPDATE topics SET title = :title, category_id = :category_id WHERE topic_id = :topic_id";
        
        $stmt = $db->prepare($request);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':topic_id', $topic_id);
        $stmt->execute();
        
        return TRUE;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function updateComment($comment_id, $content)
{
    global $db;
    try {
        $request = "UPDATE comments SET content = :content WHERE comment_id = :comment_id";
        
        $stmt = $db->prepare($request);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':comment_id', $comment_id);
        $stmt->execute();
        
        return TRUE;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>