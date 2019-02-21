<?php

namespace OpenClassrooms\Blog\Model;

require_once("model/Manager.php");

class AdminCommentManager extends Manager
{
    public function getComments()
    {
        $db = $this->dbConnect();
        $comments = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr, report FROM comments WHERE report = 0 ORDER BY comment_date DESC');

        return $comments;
    }

    public function getCommentsReported()
    {
        $db = $this->dbConnect();
        $commentsReported = $db->query('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr, report FROM comments WHERE report != 0 ORDER BY comment_date DESC');

        return $commentsReported;
    }

    public function commentToDelete($commentId)
    {
        $db = $this->dbConnect();
        $comment = $db->prepare('DELETE FROM comments WHERE id = ?');
        $affectedLines = $comment->execute(array($commentId)); 

        return $affectedLines;
    }

    public function ReportCommentToCancel($commentId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('UPDATE comments SET report = 0 WHERE id = ?');
        $affectedLines = $comments->execute(array($commentId));

        return $affectedLines;
    }
}