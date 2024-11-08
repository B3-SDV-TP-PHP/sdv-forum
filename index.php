<?php 
require "header.php";
require "addData.php";
?>
<style>
<?php include 'styles.scss'; ?>
</style>

<div style="min-height: 100vh; margin-top: 16px;">
    <?php require "data.php"; ?>
    <h1>Gestion des contacts</h1>
    <?php

    $name = "";
    $lastname = "";
    $phone = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        if (addData($name, $lastname, $phone)) {
            echo "Contact ajouté :<br>
            Prénom : " . htmlspecialchars($name) . "<br>
            Nom : " . htmlspecialchars($lastname) . "<br>
            Téléphone : " . htmlspecialchars($phone) . "<br>";
            header("Location: index.php?addData");
        }
        
        exit();
    }

    if (isset($_GET['addData'])) {
        echo $_GET['addData'];
    }
    ?>

    <form action='index.php' method='post'>
        <label for='name'>Prénom: </label>
        <input type='text' name='name'>
        <label for='lastname'>Nom: </label>
        <input type='text' name='lastname'>
        <label for='phone'>Téléphone: </label>
        <input type='text' name='phone'>
        <input type='submit' value='Ajouter un contact'>
    </form>
</div>
<?php
require "footer.php";
?>