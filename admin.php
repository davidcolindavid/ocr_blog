<?php
session_start();
require('controller/backend.php');

try {
    // check if the user is connected
    if (isset($_SESSION['id']) AND isset($_SESSION['pseudo'])) {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'listPosts') {
                ListPostsComments();
            }
            elseif ($_GET['action'] == 'addPost') {
                addPost();
            }
            elseif ($_GET['action'] == 'deletePost') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    deletePost();
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            elseif ($_GET['action'] == 'editPost') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    editPost();
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            elseif ($_GET['action'] == 'updatePost') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (!empty($_POST['post_title']) && !empty($_POST['post_content'])) {
                        updatePost($_GET['id'], $_POST['post_title'], $_POST['post_content']);
                    }
                    else {
                        throw new Exception('Tous les champs ne sont pas remplis !');
                    }
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            elseif ($_GET['action'] == 'deleteComment') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    deleteComment();
                }
                else {
                    throw new Exception('Aucun identifiant de commentaire envoyé');
                }
            }
            elseif ($_GET['action'] == 'cancelReportComment') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    cancelReportComment();
                }
                else {
                    throw new Exception('Aucun identifiant de commentaire envoyé');
                }
            }
            elseif ($_GET['action'] == 'logout') {
                logout();
            }
        }
        else {
            listPostsComments();
        }
    }
    // go to login page if the user is not connected
    else {
        header('Location: login.php');
    }
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
