<?php 
require_once "../components/header.php";
require_once "../services/getData.php";
?>
<link rel="stylesheet" href="../assets/styles/default.scss">

<div class="default-position">
    <h1>Connexion</h1>
    <?php

    $login = "";
    $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $token = bin2hex(random_bytes(32));
        if (login($login, $password, $token)) {
            setcookie("token", $token, time() + (24 * 60 * 60), "/");
            header("Location: index.php");
        }
        else {
            header("Location: login.php?login=Erreur lors de la connexion");
        }
    }

    if (isset($_GET['login'])) {
        echo $_GET['login'];
    }
    ?>

    <form action='login.php' method='post'>
        <label for='login'>Nom d'utilisateur: </label>
        <input type='text' name='login'>
        <label for='password'>Mot de passe: </label>
        <input type='password' name='password'>
        <input type='submit' value='Se connecter'>
    </form>

    <p>Pas encore de compte ? <a href='../pages/register.php'>Créer un compte</a></p>

</div>
<?php
require_once "../components/footer.php";
?>