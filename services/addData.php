<?php
$db = new PDO('mysql:host=localhost;dbname=sdv_forum', 'root', '');


function register($username, $password, $email, $token)
{
    global $db;
    try {
        if (isset($username) && isset($password) && isset($email) && isset($token)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $request = "INSERT INTO users (username, password, email, token) VALUES (:username, :password, :email, :token)";
            $stmt = $db->prepare($request);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            return TRUE;
        } else {
            return FALSE;
        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function addTopic($title, $user_id, $category_id)
{
    global $db;
    try{
        if (isset($title) && isset($user_id) && isset($category_id)) {
            $created_at = date('Y-m-d H:i:s'); // Obtenir la date et l'heure actuelles
            $request = "INSERT INTO topics (title, user_id, category_id, created_at) VALUES (:title, :user_id, :category_id, :created_at)";
            $stmt = $db->prepare($request);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->execute();

            // Récupérer l'ID du topic nouvellement inséré
            $topic_id = $db->lastInsertId();

            // Récupérer les détails du topic créé
            $stmt = $db->prepare("SELECT * FROM topics WHERE topic_id = :id");
            $stmt->bindParam(':id', $topic_id);
            $stmt->execute();
            $topic = $stmt->fetch(PDO::FETCH_ASSOC);

            return $topic;
        } else {
            return FALSE;
        }
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
}

function addComment($topic_id, $user_id, $content)
{
    global $db;
    try {
        if (isset($topic_id) && isset($user_id) && isset($content)) {
            $created_at = date('Y-m-d H:i:s'); // Obtenir la date et l'heure actuelles
            $request = "INSERT INTO comments (topic_id, user_id, content, created_at) VALUES (:topic_id, :user_id, :content, :created_at)";
            $stmt = $db->prepare($request);
            $stmt->bindParam(':topic_id', $topic_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->execute();
            return TRUE;
        } else {
            return FALSE;
        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

?>