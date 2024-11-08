<?php 
require_once "../components/header.php";
require_once "../services/addData.php";
?>
<link rel="stylesheet" href="../assets/styles/default.scss">

<div class="default-position">
    <h1>Création d'un compte</h1>
    <?php

    $username = "";
    $password = "";
    $email = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $token = bin2hex(random_bytes(32));
        if (register($username, $password, $email, $token)) {
            setcookie("token", $token, time() + (24 * 60 * 60), "/");
            header("Location: index.php");
        }
        
        exit();
    }

    if (isset($_GET['register'])) {
        echo $_GET['register'];
    }
    ?>

    <form action='register.php' method='post'>
        <label for='username'>Nom d'utilisateur: </label>
        <input type='text' name='username'>
        <label for='password'>Mot de passe: </label>
        <input type='password' name='password'>
        <label for='email'>E-Mail: </label>
        <input type='text' name='email'>
        <input type='submit' value='Créer un compte'>
    </form>

    <p>Déjà un compte ? <a href='../pages/login.php'>Connexion</a></p>

</div>
<?php
require_once "../components/footer.php";
?>