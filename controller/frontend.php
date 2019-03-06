<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

function listPosts($currentPage)
{   
    
    $perPage = 4;
    //$currentPage = 1;

    $postManager = new \OpenClassrooms\Blog\Model\PostManager(); // Création d'un objet
    $posts = $postManager->getPosts($perPage, $currentPage); // Appel d'une fonction de cet objet
    $paging = $postManager->getPaging();
    
    // Donnée pour la pagination
    $nbPage = ceil($paging['nb_posts'] / $perPage);
    // Donnée pour définir le folio d'un billet
    if (isset($_GET['id'])) {
        $folio =  ($paging['nb_posts']+1) - (($_GET['id'] - 1) * $perPage);
    } 
    else {
        $folio = $paging['nb_posts']+1;
    }

    require('view/frontend/listPostsView.php');
}

function post()
{
    $postManager = new \OpenClassrooms\Blog\Model\PostManager();
    $commentManager = new \OpenClassrooms\Blog\Model\CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontend/postView.php');
}

function addComment($postId, $author, $comment)
{
    $commentManager = new \OpenClassrooms\Blog\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}

function reportComment($commentId, $postId)
{
    $commentManager = new \OpenClassrooms\Blog\Model\CommentManager();

    $affectedLines = $commentManager->commentToReport($commentId);

    if ($affectedLines === false) {
        throw new Exception('Impossible de signaler le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}