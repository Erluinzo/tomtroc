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

    //count the messages received by a member and not read yet
    public function countUnread(int $userId): int
    {
        $sql = "SELECT COUNT(*)
                FROM messages m
                INNER JOIN conversations c ON c.id = m.conversation_id
                WHERE (c.user_one_id = :uid_a OR c.user_two_id = :uid_b)
                  AND m.sender_id <> :uid_c
                  AND m.is_read = 0";
        return (int) $this->db
            ->query($sql, ['uid_a' => $userId, 'uid_b' => $userId, 'uid_c' => $userId])
            ->fetchColumn();
    }

    //mark the messages received in a conversation as read
    public function markConversationRead(int $conversationId, int $userId): void
    {
        $sql = "UPDATE messages
                SET is_read = 1
                WHERE conversation_id = :cid AND sender_id <> :uid AND is_read = 0";
        $this->db->query($sql, ['cid' => $conversationId, 'uid' => $userId]);
    }
}
