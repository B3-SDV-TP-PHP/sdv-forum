<?php
function addData($name, $lastname, $phone)
{
    try{
        $db = new PDO('mysql:host=localhost;dbname=supdevinci', 'root', '');
        if (isset($name) && isset($lastname) && isset($phone)) {
        $request = "INSERT INTO user (firstname, lastname, phone) VALUES ('" . $name . "', '" . $lastname . "', '" . $phone . "')";
        $db->exec($request);
        return TRUE;
    } else {
        return FALSE;
    }
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
}
?>