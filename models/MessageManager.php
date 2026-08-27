<?php

//data access for the messages
class MessageManager extends AbstractEntityManager
{
    //get every message of a conversation, oldest first
    public function getMessages(int $conversationId): array
    {
        $sql = "SELECT id, sender_id, content, created_at
                FROM messages
                WHERE conversation_id = :cid
                ORDER BY created_at ASC, id ASC";
        $result = $this->db->query($sql, ['cid' => $conversationId]);

        $messages = [];
        while ($row = $result->fetch()) {
            $messages[] = new Message($row);
        }
        return $messages;
    }

    //post a new message in a conversation
    public function sendMessage(int $conversationId, int $senderId, string $content): void
    {
        $sql = "INSERT INTO messages (conversation_id, sender_id, content)
                VALUES (:cid, :sender, :content)";
        $this->db->query($sql, [
            'cid' => $conversationId,
            'sender' => $senderId,
            'content' => $content,
        ]);
    }
}
