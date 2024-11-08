<link rel="stylesheet" href="../assets/styles/pages/topic.scss">

<?php
function showTopic($username, $created_at, $category, $title)
{
    echo '
    <div class="topic-content">
        <div class="topic-first">
            <p>Par : <br>'. htmlspecialchars($username)  . '</p>
            <p>Le : <br>'. htmlspecialchars($created_at) . '</p>
            <p>Titre : <br>'. htmlspecialchars($title) . '</p>
            <p>Catégorie : <br>'. htmlspecialchars($category) . '</p>
        </div>
    </div>';
}
?>

