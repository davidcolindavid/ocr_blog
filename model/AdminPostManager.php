<?php

namespace OpenClassrooms\Blog\Model;

require_once("model/Manager.php");

class AdminPostManager extends Manager
{
    public function getPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts ORDER BY creation_date DESC');

        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function getLastPost()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 1');
        $LastPost = $req->fetch();


        return $LastPost;
    }

    public function postToAdd()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content) VALUES(:title, :content)');
        $affectedLines = $req->execute(array(
            'title' => $_POST['post_title'],
            'content' => $_POST['post_content']
        )); 

        return $affectedLines;
    }

    public function postToDelete($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM posts WHERE id = ?');
        $affectedLines = $req->execute(array($postId)); 

        return $affectedLines;
    }

    public function postToEdit($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $form = $req->fetch();

        return $form;
    }

    public function postToUpdate($postId, $title, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE posts SET title = ? , content = ? WHERE id = ?');
        $affectedLines = $req->execute(array($title, $content, $postId)); 

        return $affectedLines;
    }
}