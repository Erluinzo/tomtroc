<?php

//data access for the conversations
class ConversationManager extends AbstractEntityManager
{
    //list the conversations of a member, latest activity first
    public function getConversationsForUser(int $userId): array
    {
        $sql = "SELECT c.id,
                       u1.id AS u1_id, u1.username AS u1_name, u1.avatar AS u1_avatar,
                       u2.id AS u2_id, u2.username AS u2_name, u2.avatar AS u2_avatar,
                       (SELECT content FROM messages WHERE conversation_id = c.id ORDER BY id DESC LIMIT 1) AS last_message,
                       (SELECT created_at FROM messages WHERE conversation_id = c.id ORDER BY id DESC LIMIT 1) AS last_message_at
                FROM conversations c
                INNER JOIN users u1 ON u1.id = c.user_one_id
                INNER JOIN users u2 ON u2.id = c.user_two_id
                WHERE c.user_one_id = :uid_a OR c.user_two_id = :uid_b
                ORDER BY last_message_at DESC, c.id DESC";
        $result = $this->db->query($sql, ['uid_a' => $userId, 'uid_b' => $userId]);

        $conversations = [];
        while ($row = $result->fetch()) {
            $conversations[] = $this->buildConversation($row, $userId);
        }
        return $conversations;
    }

    //get one conversation only if the member takes part in it
    public function getConversationForUser(int $id, int $userId): ?Conversation
    {
        $sql = "SELECT c.id,
                       u1.id AS u1_id, u1.username AS u1_name, u1.avatar AS u1_avatar,
                       u2.id AS u2_id, u2.username AS u2_name, u2.avatar AS u2_avatar
                FROM conversations c
                INNER JOIN users u1 ON u1.id = c.user_one_id
                INNER JOIN users u2 ON u2.id = c.user_two_id
                WHERE c.id = :id AND (c.user_one_id = :uid_a OR c.user_two_id = :uid_b)";
        $result = $this->db->query($sql, ['id' => $id, 'uid_a' => $userId, 'uid_b' => $userId]);
        $row = $result->fetch();

        return $row ? $this->buildConversation($row, $userId) : null;
    }

    //find the conversation between two members or create it, return its id
    public function findOrCreate(int $userA, int $userB): int
    {
        $low = min($userA, $userB);
        $high = max($userA, $userB);

        $existing = $this->db
            ->query("SELECT id FROM conversations WHERE user_one_id = :low AND user_two_id = :high", ['low' => $low, 'high' => $high])
            ->fetchColumn();
        if ($existing) {
            return (int) $existing;
        }

        $this->db->query(
            "INSERT INTO conversations (user_one_id, user_two_id) VALUES (:low, :high)",
            ['low' => $low, 'high' => $high]
        );
        return (int) $this->db->lastInsertId();
    }

    //build a conversation from a row, keeping the other participant
    private function buildConversation(array $row, int $userId): Conversation
    {
        $otherIsOne = ((int) $row['u1_id']) !== $userId;

        return new Conversation([
            'id' => $row['id'],
            'other_id' => $otherIsOne ? $row['u1_id'] : $row['u2_id'],
            'other_username' => $otherIsOne ? $row['u1_name'] : $row['u2_name'],
            'other_avatar' => $otherIsOne ? $row['u1_avatar'] : $row['u2_avatar'],
            'last_message' => $row['last_message'] ?? null,
            'last_message_at' => $row['last_message_at'] ?? null,
        ]);
    }
}
