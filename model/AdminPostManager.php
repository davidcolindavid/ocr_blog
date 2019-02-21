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
}