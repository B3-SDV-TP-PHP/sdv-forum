<style>
<?php include '../assets/styles/components/header.scss'; ?>
</style>

<?php
    require_once "../components/verifyToken.php";
    require_once '../services/getData.php'; 

    $user = verifyUser($_COOKIE['token'] ?? null);
?>

<div class="navbar">
    <a href="../pages/index.php"><img src="../assets/images/sdv-logo.png"></a>
    <div class="left-part">
        <a href="../pages/index.php">Accueil</a>
        <?php
            if($user) {
                echo "<a href='../pages/forumCreation.php'>Créer un forum</a>";
            }
        ?>
    </div>
    <div class="right-part">
    <?php 
        if (!$user) {
            echo "<a href='../pages/login.php'>Login</a>";
        } else {
            echo "<a href='../pages/params.php'>";
            echo "<div class='profil'>";
            echo "<img src='../assets/images/user.svg'>";
            echo "<p>" . htmlspecialchars($user['username']) . "</p>";
            echo "</div>";
            echo "</a>";
            
            echo "<form class='logout-btn' action='../pages/logout.php' method='post' style='display: inline;'>";
            echo "<button type='submit'>Déconnexion</button>";
            echo "</form>";
        }
    ?>
    </div>
</div>