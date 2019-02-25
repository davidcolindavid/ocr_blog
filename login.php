<?php
require('controller/backend.php');

try { // On essaie de faire des choses
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'loginAdmin') {
            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                loginAdmin($_POST['username'], $_POST['password']);
            }
            else {
                // Erreur ! On arrête tout, on envoie une exception, donc au saute directement au catch
                throw new Exception('Tous les champs ne sont pas remplis !');
            }
        }
    }
    else {
        require('view/backend/loginView.php');
    }
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    echo 'Erreur : ' . $e->getMessage();
}
