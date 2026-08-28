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

    //save the personal information form
    public function update(): void
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect('login');
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('account');
        }

        $userId = (int) $_SESSION['user']['id'];
        $userManager = new UserManager();
        $current = $userManager->getUserById($userId);

        $username = trim(Utils::request('username', ''));
        $email = trim(Utils::request('email', ''));
        $password = Utils::request('password', '');

        $errors = $this->validateProfile($userManager, $current, $username, $email, $password);

        //validation failed, show the page again with the submitted values
        if (!empty($errors)) {
            $current->setUsername($username);
            $current->setEmail($email);
            $books = (new BookManager())->getBooksByUser($userId);

            $view = new View("Mon compte");
            $view->render("account", [
                'user' => $current,
                'books' => $books,
                'errors' => $errors,
            ]);
            return;
        }

        $userManager->updateProfile($userId, $username, $email);
        if ($password !== '') {
            $userManager->updatePassword($userId, password_hash($password, PASSWORD_BCRYPT));
        }

        //keep the session in sync with the new pseudo
        $_SESSION['user']['username'] = $username;

        Utils::redirect('account&saved=1');
    }

    //upload and store a new profile picture
    public function uploadAvatar(): void
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect('login');
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('account');
        }

        $userId = (int) $_SESSION['user']['id'];
        $upload = $_FILES['avatar'] ?? [];

        //refused files send the member back with a message
        if (!Utils::hasUpload($upload) || Utils::imageUploadError($upload) !== null) {
            Utils::redirect('account&error=avatar');
        }

        $path = Utils::saveSquareImage($upload, 'avatars', 300);
        if (!$path) {
            Utils::redirect('account&error=avatar');
        }

        $userManager = new UserManager();
        $old = $userManager->getUserById($userId)->getAvatar();
        $userManager->updateAvatar($userId, $path);

        //remove the previous file to avoid orphans
        if ($old && is_file('img/' . $old)) {
            unlink('img/' . $old);
        }

        Utils::redirect('account&saved=avatar');
    }

    //check the submitted profile, return the list of errors
    private function validateProfile(UserManager $userManager, User $current, string $username, string $email, string $password): array
    {
        $errors = [];

        if ($username === '' || $email === '') {
            $errors[] = "Le pseudo et l'adresse email sont obligatoires.";
        }
        if (strlen($username) > User::USERNAME_MAX_LENGTH) {
            $errors[] = 'Le pseudo ne doit pas dépasser ' . User::USERNAME_MAX_LENGTH . ' caractères.';
        }
        if (strlen($email) > User::EMAIL_MAX_LENGTH) {
            $errors[] = "L'adresse email ne doit pas dépasser " . User::EMAIL_MAX_LENGTH . ' caractères.';
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }
        if ($password !== '' && strlen($password) < User::PASSWORD_MIN_LENGTH) {
            $errors[] = 'Le mot de passe doit contenir au moins ' . User::PASSWORD_MIN_LENGTH . ' caractères.';
        }
        if (strlen($password) > User::PASSWORD_MAX_LENGTH) {
            $errors[] = 'Le mot de passe ne doit pas dépasser ' . User::PASSWORD_MAX_LENGTH . ' caractères.';
        }

        //email and pseudo must stay unique (ignoring the current member)
        if (empty($errors) && $email !== $current->getEmail()) {
            $other = $userManager->getUserByEmail($email);
            if ($other && $other->getId() !== $current->getId()) {
                $errors[] = "Cette adresse email est déjà utilisée.";
            }
        }
        if (empty($errors) && $username !== $current->getUsername()) {
            $other = $userManager->getUserByUsername($username);
            if ($other && $other->getId() !== $current->getId()) {
                $errors[] = "Ce pseudo est déjà utilisé.";
            }
        }

        return $errors;
    }
}

