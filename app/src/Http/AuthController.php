<?php

namespace Http;

class AuthController extends BaseController {
    public function login(){
        $name = 'Login';

        if (isset($_SESSION['loggedin'])) {
            header('Location: /');
            die();
        }
        $formErrors = [];
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (trim($username) != '') {
            $user = $this->validateLogin($username, $password);
            if (isset($user['id'])) {
                $this->handleLogin($user);
            } else {
                $formErrors[] = 'Wrong credentials';
            }
        }
        
        if (isset($_SESSION['loggedin'])) {
            header('Location: /');
            die();
        }

        $tpl = $this->twig->load('login.twig');
        echo $tpl->render([
            'header' => $name,
            'formErrors' => $formErrors,
            'username' => $username
        ]);
    }

    public function logout() {
        unset($_SESSION['loggedin']);
        unset($_SESSION['userid']);
        unset($_SESSION['user']);
        header('Location: /');
        die();
    }

    private function validateLogin($username, $password) {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE username = ?');
        $result = $stmt->executeQuery([$username]);
        $user = $result->fetchAssociative();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return [];
    }

    private function handleLogin($user) {
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $user['id'];
        $_SESSION['user'] = $user['username'];
    }

    public function register()
    {
        $name = 'Register';

        $formErrors = [];
        $moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';


        if ($moduleAction == 'register') {
            if (trim($username) == '') {
                $formErrors[] = 'Enter a username';
            } 

            if (trim($email) == '') {
                $formErrors[] = 'Enter an email';
            }

            if (trim($password) == '' || trim($confirmPassword) == '') {
                $formErrors[] = 'Enter passwords';
            } else {
                if (strlen($password) < 8) {
                    $formErrors[] = 'Enter a password that is minimal 8 letters long';
                }
                if ($password != $confirmPassword) {
                    $formErrors[] = 'Passwords need to be the same';
                }
            }


            if (count($formErrors) == 0) {
                $stmt = $this->conn->prepare('INSERT INTO users (username, email, password, role, added_on) VALUES (?, ?, ?, ?, ?)');
                $result = $stmt->executeStatement([$username, $email, password_hash($password, PASSWORD_DEFAULT), 'user', date("Y-m-d H:i:s")]);
                
                if ($result) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['user'] = $username;
                        $_SESSION['userid'] = $this->conn->lastInsertId();
                        header('Location: /');
                        die();
                } else {
                    $formErrors[] = 'Error occured when trying to register new user';
                }
            }
        }

        $tpl = $this->twig->load('register.twig');
        echo $tpl->render([
            'header' => $name,
            'formErrors' => $formErrors,
            'username' => $username,
            'email' => $email
        ]);
    }


}
