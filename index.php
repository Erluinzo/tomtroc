<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

//session is needed to keep the logged in user
session_start();

//get the asked action, home by default
$action = Utils::request('action', 'home');

try {
    switch ($action) {
        case 'home':
            $homeController = new HomeController();
            $homeController->showHome();
            break;

        case 'login':
            $authController = new AuthController();
            $authController->showLogin();
            break;

        case 'authenticate':
            $authController = new AuthController();
            $authController->authenticate();
            break;

        case 'logout':
            $authController = new AuthController();
            $authController->logout();
            break;

        default:
            //page not found, show the error page
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
