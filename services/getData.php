<?php
    $db = new PDO('mysql:host=localhost;dbname=sdv_forum', 'root', '');

    function getTopics($category_id = NULL)
    {
        global $db;
        try {
            if ($category_id == NULL) {
                $request = "SELECT * FROM topics";
                $stmt = $db->query($request);
            } else {
                $request = "SELECT * FROM topics WHERE category_id = :category_id";
                $stmt = $db->prepare($request);
                $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            return $stmt;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    function getMyTopics($user_id)
    {
        global $db;
        try {
            $request = "SELECT * FROM topics WHERE user_id = :user_id";
            $stmt = $db->prepare($request);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    function getCategories($category_id = NULL)
    {
        global $db;
        try {
            if ($category_id == NULL) {
                $request = "SELECT * FROM category";
                $stmt = $db->query($request);
            } else {
                $request = "SELECT * FROM category WHERE category_id = :category_id";
                $stmt = $db->prepare($request);
                $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            return $stmt;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    function login($login, $password, $token)
    {
        global $db;
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :login OR email = :login");
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                if (password_verify($password, $user['password'])) {
                    $updateStmt = $db->prepare("UPDATE users SET token = :token WHERE user_id = :user_id");
                    $updateStmt->bindParam(':token', $token);
                    $updateStmt->bindParam(':user_id', $user['user_id'], PDO::PARAM_INT);
                    $updateStmt->execute();
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    function getComments($topic_id)
    {
        global $db;
        try {
            $stmt = $db->prepare("SELECT * FROM comments WHERE topic_id = :topic_id");
            $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    function verifyToken($token)
    {
        global $db;
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE token = :token");
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
?>