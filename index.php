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

        case 'books':
            $booksController = new BooksController();
            $booksController->index();
            break;

        case 'book':
            $booksController = new BooksController();
            $booksController->show();
            break;

        case 'account':
            $accountController = new AccountController();
            $accountController->index();
            break;

        case 'editBook':
            $booksController = new BooksController();
            $booksController->showEdit();
            break;

        case 'saveBook':
            $booksController = new BooksController();
            $booksController->save();
            break;

        case 'deleteBook':
            $booksController = new BooksController();
            $booksController->delete();
            break;

        case 'login':
            $authController = new AuthController();
            $authController->showLogin();
            break;

        case 'register':
            $authController = new AuthController();
            $authController->showRegister();
            break;

        case 'signup':
            $authController = new AuthController();
            $authController->signup();
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
