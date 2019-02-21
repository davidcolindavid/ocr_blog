<?php
require('controller/frontend.php');

try { // On essaie de faire des choses
        listPosts();
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    echo 'Erreur : ' . $e->getMessage();
}
