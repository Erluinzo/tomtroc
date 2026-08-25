<?php

//handles the public book listing
class BooksController
{
    //show every book, with an optional title search
    public function index(): void
    {
        $search = trim(Utils::request('search', ''));

        $bookManager = new BookManager();
        $books = $bookManager->getAllBooks($search !== '' ? $search : null);

        $view = new View("Nos livres à l'échange");
        $view->render("books", [
            'books' => $books,
            'search' => $search,
        ]);
    }
}
