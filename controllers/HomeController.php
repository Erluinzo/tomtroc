<?php

//controller for the home page
class HomeController
{
    //show the home page with a user from the database
    public function showHome(): void
    {
        $userManager = new UserManager();
        $user = $userManager->getUserById(1);

        if (!$user) {
            throw new Exception("Aucun membre à afficher.");
        }

        $view = new View("Accueil");
        $view->render("home", ['user' => $user]);
    }
}
