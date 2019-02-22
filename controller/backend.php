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
    $commentsReported = $commentManager->getCommentsReported();

    require('view/backend/adminView.php');
}

function addPost()
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $affectedLines = $postManager->postToAdd();

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: admin.php');
    }
}

function editPost()
{   
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    $form = $postManager->postToEdit($_GET['id']);

    $commentManager = new \OpenClassrooms\Blog\Model\AdminCommentManager();
    $comments = $commentManager->getComments();
    $commentsReported = $commentManager->getCommentsReported();

    require('view/backend/adminView.php');
}

function updatePost($postId, $title, $content)
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $affectedLines = $postManager->PostToUpdate($postId, $title, $content);

    if ($affectedLines === false) {
        throw new Exception('Impossible de mettre à jour le billet !');
    }
    else {
        header('Location: admin.php');
    }
}

function deletePost()
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $affectedLines = $postManager->postToDelete($_GET['id']);

    if ($affectedLines === false) {
        throw new Exception('Impossible de supprimer le billet !');
    }
    else {
        header('Location: admin.php');
    }
}

function deleteComment()
{
    $commentManager = new \OpenClassrooms\Blog\Model\AdminCommentManager();
    $affectedLines = $commentManager->commentToDelete($_GET['id']);

    if ($affectedLines === false) {
        throw new Exception('Impossible de supprimer le commentaire !');
    }
    else {
        header('Location: admin.php');
    }
}

function cancelReportComment()
{
    $commentManager = new \OpenClassrooms\Blog\Model\AdminCommentManager();
    $affectedLines = $commentManager->ReportCommentToCancel($_GET['id']);

    if ($affectedLines === false) {
        throw new Exception('Impossible de supprimer le commentaire !');
    }
    else {
        header('Location: admin.php');
    }
}
