<?php

// Chargement des classes
require_once('model/AdminPostManager.php');
require_once('model/AdminCommentManager.php');

function listPostsComments()
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    
    $commentManager = new \OpenClassrooms\Blog\Model\AdminCommentManager();
    $comments = $commentManager->getComments();

    require('view/backend/adminView.php');
}

function addPost()
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $affectedLines = $postManager->postToAdd();

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le billet !');
    }
    else {
        header('Location: admin.php');
    }
}