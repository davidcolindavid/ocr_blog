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
}