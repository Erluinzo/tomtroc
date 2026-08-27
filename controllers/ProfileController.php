<?php

//shows the public profile of a member
class ProfileController
{
    //display a member profile and the books he offers
    public function show(): void
    {
        $id = (int) Utils::request('id', 0);

        $user = (new UserManager())->getUserById($id);
        if (!$user) {
            throw new Exception("Ce membre n'existe pas.");
        }

        $books = (new BookManager())->getBooksByUser($id);

        $view = new View($user->getUsername());
        $view->render("publicProfile", [
            'user' => $user,
            'books' => $books,
        ]);
    }
}
