<link rel="stylesheet" href="../assets/styles/pages/data.scss">

<?php
require_once "../components/verifyToken.php";
require_once '../services/getData.php';

$user = verifyUser($_COOKIE['token']);

if (!$user){
    header('Location: ./login.php');
    exit();
}

$user_id = $user['user_id'];

try {
    $db = new PDO('mysql:host=localhost;dbname=sdv_forum', 'root', '');
    
    $categoryId = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;
    $subjectId = isset($_GET['subject_id']) && is_numeric($_GET['subject_id']) ? (int)$_GET['subject_id'] : null;

    if ($categoryId && $subjectId) {
        $subjectQuery = $db->prepare("SELECT topics.title, topics.created_at, users.username, topics.user_id
                                      FROM topics 
                                      JOIN users ON topics.user_id = users.user_id 
                                      WHERE topic_id = :subjectId
                                      ORDER BY topics.created_at DESC");
        $subjectQuery->execute(['subjectId' => $subjectId]);
        $subject = $subjectQuery->fetch();
        ?>
        <div class="forum-main">
            <?php
            if ($subject) {
                echo "<div class='forum-topic'>";
                echo "<div class='topic-main'>";
                echo "<img src='../assets/images/topic.svg'>";
                echo "<h1 class='topic-title'>" . htmlspecialchars($subject['title']) . "</h1>";
                echo "</div>";
                echo "<p class='topic-meta'>Créé par " . htmlspecialchars($subject['username']) . " le " . htmlspecialchars($subject['created_at']) . "</p>";
                echo "</div>";

                $commentsQuery = $db->prepare("SELECT comments.comment_id, comments.content, comments.user_id, comments.created_at, users.username 
                                            FROM comments 
                                            JOIN users ON comments.user_id = users.user_id 
                                            WHERE comments.topic_id = :subjectId 
                                            ORDER BY comments.created_at ASC");
                $commentsQuery->execute(['subjectId' => $subjectId]);

                
                if ($commentsQuery->rowCount() > 0) {
                    while ($comment = $commentsQuery->fetch()) {
                        echo "<div class='comments'>";
                        echo "<div class='comment'>";
                        echo "<p class='comment-user'><img src='../assets/images/user.svg'>" . htmlspecialchars($comment['username']) . " <span class='comment-date'> le " . htmlspecialchars($comment['created_at']) . "</span></p>";
                        echo "<p class='comment-content'>" . htmlspecialchars($comment['content']) . "</p>";
                        if($comment['user_id'] == $user_id) {
                            echo "<form class='comment-bin' action='../components/deleteComment.php' method='post'>";
                                echo "<input type='hidden' name='comment_id' value='" . htmlspecialchars($comment['comment_id']) . "'>";
                                echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($user_id) . "'>";
                                echo "<button type='submit'><img src='../assets/images/bin.svg'></button>";
                            echo "</form>";
                        }
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='no-comments'>Aucun commentaire pour ce sujet.</p>";
                }
                ?>
                <div class="add-comment">
                    <h2>Ajouter un commentaire</h2>
                    <form action="../pages/addComment.php" method="post">
                        <input type="hidden" name="category_id" value="<?php echo $categoryId; ?>">
                        <input type="hidden" name="topic_id" value="<?php echo $subjectId; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <textarea name="content" placeholder="Votre commentaire" required></textarea>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            <?php
            } else {
                echo "<p>Le sujet demandé n'existe pas.</p>";
            }
        ?>
        </div>
    <?php
    } elseif (isset($categoryId)) {
        $query = $db->prepare("SELECT * FROM topics WHERE category_id = :categoryId ORDER BY created_at DESC");
        $query->execute(['categoryId' => $categoryId]);
        
        echo "<h1>Liste des sujets de la catégorie</h1>";
?>
        <table>
            <thead>
                <tr>
                    <th>Nom des sujets</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($query->rowCount() > 0) {
                    while ($row = $query->fetch()) { ?>
                        <tr>
                            <td>
                                <?php
                                echo "<div class='subject-content'><a href='../pages/index.php?id=" . $categoryId . "&subject_id=" . $row['topic_id'] . "'>→ " . htmlspecialchars($row['title']) . "</a>";
                                if ($row['user_id'] == $user_id) {
                                    echo "<form class='topic-bin' action='../components/deleteTopic.php' method='post'>";
                                    echo "<input type='hidden' name='topic_id' value='" . htmlspecialchars($row['topic_id']) . "'>";
                                    echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($user_id) . "'>";
                                    echo "<button type='submit'><img src='../assets/images/bin.svg'></button>";
                                    echo "</form></div>";
                                }           
                                ?>
                            </td>
                        </tr>
                    <?php 
                    }
                } else { ?>
                    <tr>
                        <td colspan="1">Aucun sujet dans cette catégorie.</td>
                    </tr>
                <?php 
                } ?>
            </tbody>
        </table>
<?php
    } else {
        $query = $db->query("SELECT * FROM category");
        
        echo "<h1>Liste des catégories</h1>";
?>
        <table>
            <thead>
                <tr>
                    <th>Nom des catégories</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $query->fetch()) { ?>
                    <tr>
                        <td>
                            <?php echo "<a href='../pages/index.php?id=" . $row['category_id'] . "'>→ " . htmlspecialchars($row['name']) . "</a>"; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if ($categoryId && $subjectId) { ?>
            <div class="add-comment">
                <h2>Ajouter un commentaire</h2>
                <form action="../pages/add_comment.php" method="post">
                    <input type="hidden" name="topic_id" value="<?php echo $subjectId; ?>">
                    <input type="hidden" name="user_id" value="1">
                    <textarea name="content" placeholder="Votre commentaire" required></textarea>
                    <button type="submit">Envoyer</button>
                </form>
            </div>
        <?php } ?>
<?php
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
