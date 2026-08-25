<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

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

        default:
            //page not found, show the error page
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
