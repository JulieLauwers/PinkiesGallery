<?php

namespace Http;

class AdminController extends BaseController {
    public function showAdmin() {
    $name = 'Admin';

    $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
    $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;

    $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
    $result = $stmt->executeQuery(['admin', $userId]);
    $role = $result->fetchAssociative()['role'];

    if ($role !== 'admin') {
        header('Location: /');
        die();
    }

    $stmt = $this->conn->prepare('SELECT * FROM messages;');
    $result = $stmt->executeQuery();
    $messages = $result->fetchAllAssociative();

    if ($role !== 'admin') {
        header('Location: /');
            die();
    }

        $tpl = $this->twig->load('admin.twig');
        echo $tpl->render([
            'header' => $name,
            'username' => $username,
            'loggedIn' => $loggedIn,
            'userId' => $userId,
            'messages' => $messages,
            'userRole' => $role
        ]);
    }

    public function add() {
        $name = 'Add photo';

        $path = '../../img/';


        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(['admin', $userId]);
        $role = $result->fetchAssociative()['role'];

        if ($role !== 'admin') {
            header('Location: /');
            die();
        }

        $moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';
        $formErrors = [];

        if ($moduleAction === 'addPhoto') {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $location = isset($_POST['location']) ? $_POST['location'] : '';

            if (isset($_FILES['photo'])) {
                $extension = '.' . (new \SplFileInfo($_FILES['photo']['name']))->getExtension();
            } else {
                $formErrors[] = 'Please provide a picture';
            }
            


            if ($title == '') {
                $formErrors[]='Enter a title!';
            }
            if ($location == '') {
                $formErrors[]='Enter a location!';
            }
            if (isset($_FILES['photo']) && in_array(strtolower((new \SplFileInfo($_FILES['photo']['name']))->getExtension()), ['jpg']) == FALSE) {
                $formErrors[] = 'Invalid extension, only jpg allowed.';
            }
    
            if (count($formErrors) == 0) {
                $moved = @move_uploaded_file($_FILES['photo']['tmp_name'], './img/' . (new \SplFileInfo($_FILES['photo']['name']))->getBasename());
                if ($moved) {
                    $stmt = $this->conn->prepare('INSERT INTO photos (title, path, name, extension, location, added_on) VALUES (?, ?, ?, ?, ?, ?)');
                    $result = $stmt->executeStatement([$title, $path, (new \SplFileInfo($_FILES['photo']['name']))->getBasename('.jpg'), $extension, $location, date("Y-m-d H:i:s")]);

                    if ($result) {
                        header('Location: /');
                        die();
                    } else {
                        $formErrors[] = 'An error has occured with your file upload';

                        $tpl = $this->twig->load('addPhoto.twig');
                        echo $tpl->render([
                            'header' => $name,
                            'username' => $username,
                            'loggedIn' => $loggedIn,
                            'userId' => $userId,
                            'userRole' => $role,
                            'formErrors' => $formErrors,
                            'title' => $title,
                            'location' => $location
                        ]);
                    }
                } else {
                    $formErrors[] = 'Error uploading file';

                    $tpl = $this->twig->load('addPhoto.twig');
                        echo $tpl->render([
                            'header' => $name,
                            'username' => $username,
                            'loggedIn' => $loggedIn,
                            'userId' => $userId,
                            'userRole' => $role,
                            'formErrors' => $formErrors,
                            'title' => $title,
                            'location' => $location
                    ]);
                }
            } else {
                $tpl = $this->twig->load('addPhoto.twig');
                echo $tpl->render([
                    'header' => $name,
                    'username' => $username,
                    'loggedIn' => $loggedIn,
                    'userId' => $userId,
                    'userRole' => $role,
                    'formErrors' => $formErrors,
                    'title' => $title,
                    'location' => $location
                ]);
            }
        } else {
            $tpl = $this->twig->load('addPhoto.twig');
            echo $tpl->render([
                'header' => $name,
                'username' => $username,
                'loggedIn' => $loggedIn,
                'userId' => $userId,
                'userRole' => $role,
                'formErrors' => $formErrors
            ]);
        }
    }

    public function detailMessage($id) {
        $name = 'Detail message';

        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(['admin', $userId]);
        $role = $result->fetchAssociative()['role'];

        if ($role !== 'admin') {
            header('Location: /');
            die();
        }

        $stmt = $this->conn->prepare('SELECT * FROM messages WHERE id = ?;');
        $result = $stmt->executeQuery([$id]);
        $message = $result->fetchAssociative();

        $tpl = $this->twig->load('messageDetail.twig');

        echo $tpl->render([
            'header'=>$name,
            'message'=>$message,
            'loggedIn' => $loggedIn,
            'username' => $username,
            'userId' => $userId,
            'userRole' => $role
        ]);
    }

    public function deleteMessage($id) {
        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';


        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(['admin', $userId]);
        $role = $result->fetchAssociative()['role'];

        if ($role !== 'admin') {
            header('Location: /');
            die();
        }

        $moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';

        if ($moduleAction === 'delete') {
            $stmt = $this->conn->prepare('DELETE FROM messages WHERE id = ?');
            $result = $stmt->executeStatement([$id]);

            header('Location: /admin');
            die();
        }
    }

}