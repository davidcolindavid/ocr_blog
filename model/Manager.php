<?php

namespace OpenClassrooms\Blog\Model;

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=blog_ocr;charset=utf8', 'root', 'root');
        return $db;
    }
}