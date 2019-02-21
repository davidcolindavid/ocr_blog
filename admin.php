<?php
require('controller/backend.php');

try { // On essaie de faire des choses
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            ListPostsComments();
        }
        elseif ($_GET['action'] == 'addPost') {
            addPost();
        }
    }
    else {
        listPostsComments();
    }
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    echo 'Erreur : ' . $e->getMessage();
}
