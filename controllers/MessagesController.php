<?php

//handles the private messaging area
class MessagesController
{
    //show the conversations list and, if asked, one conversation thread
    public function index(): void
    {
        $userId = $this->requireLogin();

        $conversationManager = new ConversationManager();
        $conversations = $conversationManager->getConversationsForUser($userId);

        $activeId = (int) Utils::request('id', 0);
        $active = null;
        $messages = [];

        if ($activeId > 0) {
            $active = $conversationManager->getConversationForUser($activeId, $userId);
            if ($active) {
                $messages = (new MessageManager())->getMessages($activeId);
            }
        }

        $view = new View("Messagerie");
        $view->render("messaging", [
            'conversations' => $conversations,
            'active' => $active,
            'messages' => $messages,
            'currentUserId' => $userId,
        ]);
    }

    //post a message in a conversation the member takes part in
    public function send(): void
    {
        $userId = $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Utils::redirect('messaging');
        }

        $conversationId = (int) Utils::request('conversation_id', 0);
        $content = trim(Utils::request('content', ''));

        $active = (new ConversationManager())->getConversationForUser($conversationId, $userId);
        if ($active && $content !== '') {
            (new MessageManager())->sendMessage($conversationId, $userId, $content);
        }

        Utils::redirect('messaging&id=' . $conversationId);
    }

    //open (or create) a conversation with another member
    public function start(): void
    {
        $userId = $this->requireLogin();
        $otherId = (int) Utils::request('user', 0);

        if ($otherId <= 0 || $otherId === $userId || !(new UserManager())->getUserById($otherId)) {
            Utils::redirect('messaging');
        }

        $conversationId = (new ConversationManager())->findOrCreate($userId, $otherId);
        Utils::redirect('messaging&id=' . $conversationId);
    }

    //guests are sent to the login page
    private function requireLogin(): int
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect('login');
        }
        return (int) $_SESSION['user']['id'];
    }
}
