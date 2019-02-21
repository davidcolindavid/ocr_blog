<?php
require('controller/backend.php');

try { // On essaie de faire des choses
        listPostsComments();
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    echo 'Erreur : ' . $e->getMessage();
}
