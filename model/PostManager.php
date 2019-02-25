<?php

namespace OpenClassrooms\Blog\Model;

require_once("model/Manager.php");

class PostManager extends Manager
{
    public function getPosts($perPage, $currentPage)
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT '.(($currentPage-1)*$perPage).','.$perPage.'');

        return $req;
    }

    public function getPaging()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(*) AS nb_posts FROM posts '); //récupère le contenu de la requête dans $req
        $nbPosts = $req->fetch();
      
        
        return $nbPosts;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }
}