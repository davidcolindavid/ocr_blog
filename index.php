<?php
require('controller/frontend.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            $currentPage = 1; // pagination: homepage = firstpage
            listPosts($currentPage);
        }
        elseif ($_GET['action'] == 'page') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $currentPage = $_GET['id'];
                listPosts($currentPage);
            }
            else {
                $currentPage = 1;
            }
        }
        elseif ($_GET['action'] == 'post') { // single post
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post();
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'reportComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                reportComment($_GET['id'], $_GET['postId']);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
    }
    else {
        $currentPage = 1;
        listPosts($currentPage);
    }
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
