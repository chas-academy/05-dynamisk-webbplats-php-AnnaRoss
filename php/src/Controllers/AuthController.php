<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\UserModel;

class AuthController extends AbstractController
{
    public function signIn()
    {
        $params = $this->request->getParams();
        $email = $params->get('email');
        $password = $params->get('password');

        $userModel = new UserModel();
        $user = $userModel->getByEmail($email);
        
        // Redirect if there's no user with that email
        if (!$user) {
            return $this->redirect('/articles');
        }

        $passwordMatches = password_verify($password, $user->getPassword());

        if (!$passwordMatches) {
            return $this->redirect('/articles');
        }

        // Save user in the Session
        $_SESSION['user'] = $user;
        
        return $this->redirect('/articles');
    }

    public function signOut()
    {
        $_SESSION['user'] = null;

        return $this->redirect('/articles');
    }
}
