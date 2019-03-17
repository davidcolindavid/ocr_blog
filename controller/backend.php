<?php

// load the classes
require_once('model/loginManager.php');
require_once('model/AdminPostManager.php');
require_once('model/AdminCommentManager.php');

function loginAdmin($username, $password)
{   
    $loginManager = new \OpenClassrooms\Blog\Model\LoginManager(); // creation of an object
    $correctPassword = $loginManager->getPass($username, $password); // call a function of this object
    $user =  $loginManager->getUser($username);

    if($correctPassword){
        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['pseudo'] = $username;
        // redirect to the admin page width ajax (backend.js)
        echo "success";
	}else{
		// Report an error: wrong id or password width ajax (backend.js)
        echo "fail";
	}
}

function logout()
{   
    session_start();
    
    $_SESSION = array();
    session_destroy();

    header('Location: login.php');
}

function listPostsComments()
{
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $posts = $postManager->getPosts();
    
    $commentManager = new \OpenClassrooms\Blog\Model\AdminCommentManager();
    $comments = $commentManager->getComments();
    $commentsReported = $commentManager->getCommentsReported();

    // editor and fields init
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

    // editor and fields init
    $lastPostId = $lastpost['id'];
    $lastPostTitle = $lastpost['title'];
    $lastPostDate = $lastpost['creation_date_fr'];

    if (isAjax()) { 
        $array = [$lastPostId, $lastPostTitle, $lastPostDate];
        header('Content-type: application/json');
        echo json_encode($array); // transform the array into JSON
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
    $postManager = new \OpenClassrooms\Blog\Model\AdminPostManager();
    $posts = $postManager->getPosts();
    $form = $postManager->postToEdit($_GET['id']);

    $commentManager = new \OpenClassrooms\Blog\Model\AdminCommentManager();
    $comments = $commentManager->getComments();
    $commentsReported = $commentManager->getCommentsReported();

    // editor and fields init
    $formTitle = $form['title'];
    $formContent = $form['content'];
    $formAction = "admin.php?action=updatePost&id=" . $form['id'];

    if (isAjax()) { 
        $array = [$formTitle, $formContent, $formAction];
        header('Content-type: application/json');
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
        header('Content-type: application/json');
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