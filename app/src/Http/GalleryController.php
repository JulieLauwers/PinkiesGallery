<?php

namespace Http;

class GalleryController extends BaseController {
    public function showGallery() {
        $name = 'Gallery';

        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $statment = $this->conn->prepare('SELECT * FROM photos;');
        $result = $statment->executeQuery();
        $photos = $result->fetchAllAssociative();

        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(['admin', $userId]);
        $role = $loggedIn ? $result->fetchAssociative()['role'] : '';

        $tpl = $this->twig->load('gallery.twig');

        echo $tpl->render([
           'header'=>$name,
           'photos'=>$photos,
           'loggedIn' => $loggedIn,
            'username' => $username,
            'userId' => $userId,
            'userRole' => $role
        ]);

    }

    public function showPhoto($id) {
        $name = 'Detail';

        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $stmt = $this->conn->prepare('SELECT * FROM photos WHERE id = ?;');
        $result = $stmt->executeQuery([$id]);
        $photo = $result->fetchAssociative();

        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(['admin', $userId]);
        $role = $result->fetchAssociative()['role'];

        $tpl = $this->twig->load('detail.twig');

        echo $tpl->render([
            'header'=>$name,
            'photo'=>$photo,
            'loggedIn' => $loggedIn,
            'username' => $username,
            'userId' => $userId,
            'userRole' => $role
        ]);
    }

    public function deletePhoto($id) {
        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';


        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(['admin', $userId]);
        $role = $result->fetchAssociative()['role'];

        if (!$loggedIn || $role !== 'admin') {
            header('Location: /');
            die();
        }

        $moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';

        if ($moduleAction === 'deletePhoto') {
            $stmt = $this->conn->prepare('DELETE FROM photos WHERE id = ?');
            $result = $stmt->executeStatement([$id]);

            header('Location: /gallery');
            die();
        }
    }
}