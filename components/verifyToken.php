<?php
require_once '../services/getData.php'; 


function verifyUser($token = null) {
    if (!$token) {
        return null;
    }
    $data = verifyToken($token);

    if ($data) {
        return $data;
    } else {
        return null;
    }
}