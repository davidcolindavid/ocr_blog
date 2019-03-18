<?php

// load the classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

function listPosts($currentPage)
{   
    $perPage = 4;
    //$currentPage = 1;

    $postManager = new \OpenClassrooms\Blog\Model\PostManager(); // creation of an object
    $posts = $postManager->getPosts($perPage, $currentPage); // call a function of this object
    $paging = $postManager->getPaging();
    
    // data for the pagination
    $nbPage = ceil($paging['nb_posts'] / $perPage);
    // data to define folio of the post
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

    // data for the ajax request / add the comment to the DOM
    $lastCommentId = $lastComment['id'];
    $lastCommentAuthor = htmlspecialchars($lastComment['author']);
    $lastCommentDate = $lastComment['comment_date_fr'];
    $lastCommentContent = nl2br(htmlspecialchars($lastComment['comment']));

    if (isAjax()) { 
        $array = [$lastCommentId, $lastCommentAuthor, $lastCommentDate, $lastCommentContent, $postId];
        header('Content-type: application/json');
        echo json_encode($array); // transform the array into JSON
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

function sendEmail($email, $message)
{   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "fail";
    } else {
        $headers = 'FROM: ' . $email;
        $headers .= "Content-type: text/html; charset=\"utf-8\"";
        mail('nom@mail.com', 'Formulaire de contact', $message, $headers);
        echo "success";
    }
}

function isAjax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}