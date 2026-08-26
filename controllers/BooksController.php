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

    //show the detail of one book
    public function show(): void
    {
        $id = (int) Utils::request('id', 0);

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        $view = new View($book->getTitle());
        $view->render("book", ['book' => $book]);
    }
}
