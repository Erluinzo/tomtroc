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

    //show the register page
    public function showRegister(): void
    {
        $view = new View("Inscription");
        $view->render("register");
    }

    //create a new account from the submitted form
    public function signup(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('register');
        }

        $username = trim(Utils::request('username', ''));
        $email = trim(Utils::request('email', ''));
        $password = Utils::request('password', '');

        $userManager = new UserManager();
        $errors = [];

        if ($username === '' || $email === '' || $password === '') {
            $errors[] = 'Tous les champs sont obligatoires.';
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }
        if ($password !== '' && strlen($password) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }
        if (empty($errors) && $userManager->getUserByEmail($email)) {
            $errors[] = 'Un compte existe déjà avec cette adresse email.';
        }
        if (empty($errors) && $userManager->getUserByUsername($username)) {
            $errors[] = 'Ce pseudo est déjà utilisé.';
        }

        //validation failed, show the form again with the messages and the values
        if (!empty($errors)) {
            $view = new View("Inscription");
            $view->render("register", [
                'errors' => $errors,
                'username' => $username,
                'email' => $email,
            ]);
            return;
        }

        //store the hashed password, never the plain one
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $userId = $userManager->createUser($username, $email, $hash);

        $_SESSION['user'] = [
            'id' => $userId,
            'username' => $username,
        ];
        Utils::redirect('home');
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
