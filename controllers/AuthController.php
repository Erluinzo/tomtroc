<?php

//handles the authentication pages
class AuthController
{
    //show the login page
    public function showLogin(): void
    {
        $view = new View("Connexion");
        $view->render("login");
    }

    //check the submitted credentials and open a session
    public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('login');
        }

        $email = Utils::request('email', '');
        $password = Utils::request('password', '');

        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);

        //compare the plain password with the stored hash
        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
            ];
            Utils::redirect('home');
        }

        //wrong credentials, show the form again with a message
        $view = new View("Connexion");
        $view->render("login", [
            'error' => 'Adresse email ou mot de passe incorrect.',
            'email' => $email,
        ]);
    }

    //close the session
    public function logout(): void
    {
        unset($_SESSION['user']);
        Utils::redirect('home');
    }
}
