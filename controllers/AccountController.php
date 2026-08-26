<?php

//handles the private account area
class AccountController
{
    //show the account page (profile + personal info), members only
    public function index(): void
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect('login');
        }

        $userId = (int) $_SESSION['user']['id'];

        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        $bookManager = new BookManager();
        $books = $bookManager->getBooksByUser($userId);

        $view = new View("Mon compte");
        $view->render("account", [
            'user' => $user,
            'books' => $books,
        ]);
    }
}
