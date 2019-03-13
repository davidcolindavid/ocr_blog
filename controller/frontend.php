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
    $lastComment = $commentManager->getComment($_GET['id']);

    if (isAjax()) { 
    ?>
        <div class="row">
            <div class="col-7 comment_details"><?= htmlspecialchars($lastComment['author']) ?>, <?= $lastComment['comment_date_fr'] ?></div>
            <form class="col-5 col_report" action="index.php?action=reportComment&amp;id=<?= $lastComment['id'] ?>&amp;postId=<?= $lastComment['post_id'] ?>" method="post">
                <button type="submit" class="btn_report">Signaler</button>
            </form>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="comment_sent"><?= nl2br(htmlspecialchars($lastComment['comment'])) ?></div>
            </div>
        </div>
    <?php
    }
    else {
        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        else {
            header('Location: index.php?action=post&id=' . $postId);
        }
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

function isAjax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}