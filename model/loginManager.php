<?php

namespace OpenClassrooms\Blog\Model;

require_once("model/Manager.php");

class LoginManager extends Manager
{
    public function getPass($username, $password)
    {
        //  Récupération de l'utilisateur et de son pass hashé
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT pass FROM user WHERE pseudo = :username');
        $req->execute(array(
            'username' => $username,
        ));
        $result = $req->fetch();

        // Comparaison du pass envoyé via le formulaire avec la base
        $correctPassword = password_verify($password, $result['pass']);

        return $correctPassword;
    }
}