<?php

//controller for the home page
class HomeController
{
    //show the home page
    public function showHome(): void
    {
        $view = new View("Accueil");
        $view->render("home");
    }
}
