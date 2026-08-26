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

    //show the add/edit form, members only
    public function showEdit(): void
    {
        $this->requireLogin();
        $id = (int) Utils::request('id', 0);

        $book = null;
        if ($id > 0) {
            $book = $this->ownedBookOrFail($id);
        }

        $view = new View($id > 0 ? 'Modifier un livre' : 'Ajouter un livre');
        $view->render("editBook", ['book' => $book]);
    }

    //save the submitted book (insert or update), members only
    public function save(): void
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('account');
        }

        $userId = (int) $_SESSION['user']['id'];
        $id = (int) Utils::request('id', 0);
        $title = trim(Utils::request('title', ''));
        $author = trim(Utils::request('author', ''));
        $description = trim(Utils::request('description', ''));
        $isAvailable = Utils::request('is_available', '1') === '0' ? 0 : 1;

        $bookManager = new BookManager();

        //a book can only be edited by its owner
        $current = $id > 0 ? $this->ownedBookOrFail($id) : null;

        //keep the current cover unless a new valid image is uploaded
        $cover = $this->saveCover($_FILES['cover'] ?? []);
        if ($cover === null && $current) {
            $cover = $current->getCover();
        }

        //validation failed, show the form again with the values
        if ($title === '' || $author === '') {
            $book = new Book([
                'id' => $id,
                'title' => $title,
                'author' => $author,
                'description' => $description,
                'cover' => $cover,
                'is_available' => $isAvailable,
            ]);
            $view = new View($id > 0 ? 'Modifier un livre' : 'Ajouter un livre');
            $view->render("editBook", [
                'book' => $book,
                'error' => "Le titre et l'auteur sont obligatoires.",
            ]);
            return;
        }

        if ($id > 0) {
            $bookManager->updateBook($id, $title, $author, $description, $cover, $isAvailable);
        } else {
            $bookManager->addBook($userId, $title, $author, $description, $cover, $isAvailable);
        }

        Utils::redirect('account');
    }

    //delete one of the member's books
    public function delete(): void
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('account');
        }

        $id = (int) Utils::request('id', 0);
        $this->ownedBookOrFail($id);

        (new BookManager())->deleteBook($id);
        Utils::redirect('account');
    }

    //stop guests from reaching the private book actions
    private function requireLogin(): void
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect('login');
        }
    }

    //return the book only if it belongs to the logged in member
    private function ownedBookOrFail(int $id): Book
    {
        $book = (new BookManager())->getBookById($id);
        if (!$book || $book->getUserId() !== (int) $_SESSION['user']['id']) {
            throw new Exception("Livre introuvable ou accès refusé.");
        }
        return $book;
    }

    //validate, resize and store an uploaded cover, return its path or null
    private function saveCover(array $file): ?string
    {
        return Utils::saveSquareImage($file, 'books', 400);
    }
}
