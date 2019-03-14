<?php

// Chargement des classes
require_once('model/loginManager.php');
require_once('model/AdminPostManager.php');
require_once('model/AdminCommentManager.php');

function loginAdmin($username, $password)
{   
    $loginManager = new \OpenClassrooms\Blog\Model\LoginManager(); // Création d'un objet
    $correctPassword = $loginManager->getPass($username, $password); // Appel d'une fonction de cet objet

    if($correctPassword){
        // Si oui redirige vers la page admin
        session_start();
        $_SESSION['correctPassword'] = $correctPassword;
        $_SESSION['pseudo'] = $username;
        echo "success";
	}else{
		// Sinon signale une erreur d'identifiant ou de mot de passe
        echo "fail";
	}
}

function logout()
{   
    session_start();
    
    // Suppression des variables de session et de la session
    $_SESSION = array();
    session_destroy();

    header('Location: login.php');
}

function listPostsComments()
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    
    $commentManager = new \OpenClassrooms\Blog\Model\AdminCommentManager();
    $comments = $commentManager->getComments();
    $commentsReported = $commentManager->getCommentsReported();

    $formTitle = "";
    $formContent = "Exprimez-vous";
    $formAction = "admin.php?action=addPost";

    require('view/backend/adminView.php');
}

function addPost()
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $affectedLines = $postManager->postToAdd();
    $lastpost = $postManager->getLastPost();

    $lastPostId = $lastpost['id'];
    $lastPostTitle = $lastpost['title'];
    $lastPostDate = $lastpost['creation_date_fr'];

    if (isAjax()) { 
        $array = [$lastPostId, $lastPostTitle, $lastPostDate];
        // J'indique au navigateur que je retourne du JSON
        header('Content-type: application/json');
        // Je transforme mon tableau en JSON et je l'imprime dans le body de ma réponse
        echo json_encode($array);
    }
    else {
        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        else {
            header('Location: admin.php');
        }
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

    $formTitle = $form['title'];
    $formContent = $form['content'];
    $formAction = "admin.php?action=updatePost&id=" . $form['id'];

    if (isAjax()) { 
        $array = [$formTitle, $formContent, $formAction];
        // J'indique au navigateur que je retourne du JSON
        header('Content-type: application/json');
        // Je transforme mon tableau en JSON et je l'imprime dans le body de ma réponse
        echo json_encode($array);
    }
    else {
        require('view/backend/adminView.php');
    }
}

function updatePost($postId, $title, $content)
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $affectedLines = $postManager->PostToUpdate($postId, $title, $content);
    $post = $postManager->getPost($postId);

    if (isAjax()) { 
        $array = [$post['title']];
        // J'indique au navigateur que je retourne du JSON
        header('Content-type: application/json');
        // Je transforme mon tableau en JSON et je l'imprime dans le body de ma réponse
        echo json_encode($array);
    }
    else {
        if ($affectedLines === false) {
            throw new Exception('Impossible de mettre à jour le billet !');
        }
        else {
            header('Location: admin.php');
        }
    }
}

function deletePost()
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $commentManager = new \OpenClassrooms\Blog\Model\AdminCommentManager();
    
    $affectedLines = $postManager->postToDelete($_GET['id']);
    $affectedLinesComm = $commentManager->commentsFromPostToDelete($_GET['id']);

    if ($affectedLines === false) {
        throw new Exception('Impossible de supprimer le billet !');
    }
    elseif ($affectedLinesComm === false) {
        throw new Exception('Impossible de supprimer les commentaires associés au billet !');
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

function isAjax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}