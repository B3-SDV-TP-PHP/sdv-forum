<?php 
require_once "../components/header.php";
require_once "../services/addData.php";
require_once '../services/getData.php'; 
require_once "../components/verifyToken.php";

?>
<link rel="stylesheet" href="../assets/styles/default.scss">

<div class="default-position">
    <h1>Création d'un forum</h1>
    <?php
    $user = verifyUser($_COOKIE['token']);
    if (!$user){
        header('Location: ./login.php');
        exit();
    }
    
    $categories = getCategories();

    $title = "";
    $user_id = $user['user_id'];
    $category_id = "";
    $comment = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $category_id = $_POST['category_id'];
        $newTopic = addTopic($title, $user_id, $category_id);
        if ($newTopic) {
            $comment = $_POST['description'];
            $newComment = addComment($newTopic['topic_id'], $user_id, $comment);
            if ($newComment) {
                header("Location: index.php?id=" . $category_id . "&subject_id=" . $newTopic['topic_id']);
                exit();            }
            else {
                header("Location: forumCreation.php?forumCreation=Erreur lors de la création du commentaire");
            }
        }
        else {
            header("Location: forumCreation.php?forumCreation=Erreur lors de la création du forum");
        }
        
        exit();
    }

    if (isset($_GET['forumCreation'])) {
        echo $_GET['forumCreation'];
    }
    ?>

    <form action='forumCreation.php' method='post'>
        <label for='title'>Titre du forum: </label>
        <input type='text' name='title'>
        <label for='title'>Catégorie: </label>
        <select name='category_id' id='category_id' style="margin-bottom: 6px;" required>
            <?php
            while ($category = $categories->fetch()) {
                echo "<option value='" . htmlspecialchars($category['category_id']) . "'>" . htmlspecialchars($category['name']) . "</option>";
            }
            ?>
        </select><br>
        <label for='description'>Description: </label>
        <textarea name='description' id='description' rows='10' cols='50' required></textarea><br>

        <input type='submit' value='Créer un forum'>
    </form>

</div>
<?php
require_once "../components/footer.php";
?>