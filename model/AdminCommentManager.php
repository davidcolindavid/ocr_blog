<?php

namespace OpenClassrooms\Blog\Model;

require_once("model/Manager.php");

class AdminCommentManager extends Manager
{
    public function getComments()
    {
        $db = $this->dbConnect();
        $comments = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM comments ORDER BY comment_date DESC');

        return $comments;
    }
}