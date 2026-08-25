<?php

//manager for the books table
class BookManager extends AbstractEntityManager
{
    //get the latest added books, with the owner name
    public function getLatestBooks(int $limit): array
    {
        $sql = "SELECT b.id, b.title, b.author, b.cover, u.username AS owner_name
                FROM books b
                INNER JOIN users u ON u.id = b.user_id
                ORDER BY b.created_at DESC
                LIMIT " . $limit;
        $result = $this->db->query($sql);

        $books = [];
        while ($row = $result->fetch()) {
            $books[] = new Book($row);
        }
        return $books;
    }
}
