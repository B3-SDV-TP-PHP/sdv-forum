<link rel="stylesheet" href="../assets/styles/default.scss">
<?php
ob_start();
require_once "../components/header.php";
require_once "../components/verifyToken.php";
require_once '../services/getData.php'; 
require_once "../components/topic.php";
require_once '../services/updateUser.php';

$user = verifyUser($_COOKIE['token']);

if (!$user){
    header('Location: ./login.php');
    exit();
}

$user_id = $user['user_id'];
$topics = getMyTopics($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashedPassword = $user['password'];
    }

    $updateResult = updateUser($user_id, $username, $email, $hashedPassword);

    if ($updateResult === true) {
        echo "<p>Paramètres mis à jour avec succès !</p>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (is_string($updateResult)) {
        echo "<p>Erreur : $updateResult</p>";
    } else {
        echo "<p>Erreur lors de la mise à jour des paramètres.</p>";
    }
}

?>
<div class="default-position">
    <h1>Paramètres utilisateur</h1>
    <form method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required><br>

        <label for="password">Nouveau mot de passe :</label>
        <input type="password" name="password" placeholder="Laissez vide pour ne pas changer"><br>

        <button type="submit">Mettre à jour</button>
    </form>
    <div>
        <h1>Mes Topics</h1>
        <?php 
        if ($topics) {
            while ($topic = $topics->fetch(PDO::FETCH_ASSOC)) {
                $username = $user['username'];
                $created_at = $topic['created_at'];
                $category_db = getCategories($topic['category_id']);
                $category = $category_db->fetch(PDO::FETCH_ASSOC)['name'];
                $title = $topic['title'];

                showTopic($username, $created_at, $category, $title);
            }
        } else {
            echo "<p>Aucun topic trouvé.</p>";
        }
        ?>
    </div>
</div>

<?php
require_once "../components/footer.php";
?>