<?php

//controller for the home page
class HomeController
{
    //show the home page
    public function showHome(): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getLatestBooks(4);

        $view = new View("Accueil");
        $view->render("home", ['books' => $books]);
    }
}
