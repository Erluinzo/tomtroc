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
}
