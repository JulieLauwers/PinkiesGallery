<?php

namespace Http;

class ContactController extends BaseController {
    public function overview() {
        $name = 'Contact';

        $loggedIn = isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : false;
        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
        $username = isset($_SESSION['user']) ? $_SESSION['user'] : '';

        $moduleAction = isset($_POST['moduleAction']) ? $_POST['moduleAction'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        $formErrors = [];

        $stmt = $this->conn->prepare('SELECT role FROM users WHERE role = ? AND id = ?');
        $result = $stmt->executeQuery(['admin', $userId]);
        $role = $result->fetchAssociative()['role'];

        if ($moduleAction == 'contact') {
            if (strlen($email) < 8) {
                $formErrors[] = 'Please enter an email';
            }
            if (strlen($subject) < 5) {
                $formErrors[] = 'Please enter a subject';
            }
            if (strlen($message) < 20) {
                $formErrors[] = 'Please enter a message longer than 20 characters';
            }

            if (count($formErrors) == 0) {
                $stmt = $this->conn->prepare('INSERT INTO messages (email, subject, question, added_on) VALUES (?, ?, ?, ?)');
                $result = $stmt->executeStatement([$email, $subject, $message, date("Y-m-d H:i:s")]);

                if ($result) {
                    header('Location: /');
                    die();
                }
            }
        }

        $tpl = $this->twig->load('contact.twig');
        echo $tpl->render([
            'header'=>$name,
            'loggedIn' => $loggedIn,
            'username' => $username,
            'userId' => $userId,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'formErrors' => $formErrors,
            'userRole' => $role
        ]);
    }
}