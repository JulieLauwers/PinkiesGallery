<?php

namespace Http;

class PinkieController extends BaseController {
    public function showIndex() {
        $name = 'Home';

        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(["admin", $userId]);
        $info = $result->fetchAssociative();

        $role = isset($info) && isset($info['role']) ? $info['role'] : '';

        $statment = $this->conn->prepare('SELECT * FROM photos LIMIT 6;'); //limit opzetten van 6
        $result = $statment->executeQuery();
        $photos = $result->fetchAllAssociative();

        $tpl = $this->twig->load('index.twig');

        echo $tpl->render([
           'header'=>$name,
           'photos'=>$photos,
           'loggedIn' => $loggedIn,
            'username' => $username,
            'userId' => $userId,
            'userRole' => $role
        ]);
    }

    public function showAbout() {
        $name = 'About';

        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(['admin', $userId]);
        $role = $result->fetchAssociative()['role'];

        $tpl = $this->twig->load('about.twig');

        echo $tpl->render([
           'header'=>$name,
           'loggedIn' => $loggedIn,
            'username' => $username,
            'userId' => $userId,
            'userRole' => $role
        ]);
    }

    public function showProfile() {
        $name = 'Account';

        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(["admin", $userId]);
        $info = $result->fetchAssociative();

        $role = isset($info) && isset($info['role']) ? $info['role'] : '';

        $statment = $this->conn->prepare('SELECT email FROM users WHERE id = ?;'); //limit opzetten van 6
        $result = $statment->executeQuery([$userId]);
        $email = $result->fetchAssociative();

        $tpl = $this->twig->load('account.twig');

        echo $tpl->render([
           'header'=>$name,
           'email'=>$email,
           'loggedIn' => $loggedIn,
            'username' => $username,
            'userId' => $userId,
            'userRole' => $role
        ]);
    }
}