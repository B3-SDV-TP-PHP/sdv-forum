<?php
require_once '../services/getData.php'; 

function updateUser($user_id, $username, $email, $hashedPassword) {
    global $db;

    try {
        $checkUsernameQuery = $db->prepare("SELECT user_id FROM users WHERE username = ? AND user_id != ?");
        $checkUsernameQuery->execute([$username, $user_id]);
        if ($checkUsernameQuery->fetch()) {
            throw new Exception("Ce nom d'utilisateur est déjà utilisé par un autre utilisateur.");
        }

        $checkEmailQuery = $db->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
        $checkEmailQuery->execute([$email, $user_id]);
        if ($checkEmailQuery->fetch()) {
            throw new Exception("Cet email est déjà utilisé par un autre utilisateur.");
        }

        $updateQuery = $db->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE user_id = ?");
        return $updateQuery->execute([$username, $email, $hashedPassword, $user_id]);
        
    } catch (PDOException $e) {
        error_log("Erreur de mise à jour de l'utilisateur : " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("Erreur de validation : " . $e->getMessage());
        return $e->getMessage();
    }
}
?>
