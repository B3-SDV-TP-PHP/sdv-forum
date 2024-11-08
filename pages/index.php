<?php 
require_once "../components/header.php";
require_once "../services/addData.php";

// Vérifie si l'ID est défini dans l'URL et si c'est un nombre
$categoryId = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;
?>
<link rel="stylesheet" href="../assets/styles/default.scss">

<div class="default-position">
    <?php 
    // Inclut le fichier data.php
    require "../components/data.php"; 
    ?>
</div>
<?php
require_once "../components/footer.php";
?>
