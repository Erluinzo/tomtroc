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

    //get every book with its owner, optionally filtered by title
    public function getAllBooks(?string $search = null): array
    {
        $sql = "SELECT b.id, b.title, b.author, b.cover, b.is_available, u.username AS owner_name FROM books b INNER JOIN users u ON u.id = b.user_id";
        $params = null;

        if ($search !== null && $search !== '') {
            $sql .= " WHERE b.title LIKE :search";
            $params = ['search' => '%' . $search . '%'];
        }

        $sql .= " ORDER BY b.created_at DESC";
        $result = $this->db->query($sql, $params);

        $books = [];
        while ($row = $result->fetch()) {
            $books[] = new Book($row);
        }
        return $books;
    }

    //get one book with its owner details
    public function getBookById(int $id): ?Book
    {
        $sql = "SELECT b.id, b.title, b.author, b.description, b.cover, b.is_available, b.user_id, u.username AS owner_name
                FROM books b
                INNER JOIN users u ON u.id = b.user_id
                WHERE b.id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $book = $result->fetch();

        if ($book) {
            return new Book($book);
        }
        return null;
    }

    //get the books owned by one user
    public function getBooksByUser(int $userId): array
    {
        $sql = "SELECT id, title, author, description, cover, is_available
                FROM books
                WHERE user_id = :user_id
                ORDER BY created_at DESC";
        $result = $this->db->query($sql, ['user_id' => $userId]);

        $books = [];
        while ($row = $result->fetch()) {
            $books[] = new Book($row);
        }
        return $books;
    }

    //insert a new book and return its id
    public function addBook(int $userId, string $title, string $author, string $description, ?string $cover, int $isAvailable): int
    {
        $sql = "INSERT INTO books (user_id, title, author, description, cover, is_available)
                VALUES (:user_id, :title, :author, :description, :cover, :is_available)";
        $this->db->query($sql, [
            'user_id' => $userId,
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'cover' => $cover,
            'is_available' => $isAvailable,
        ]);

        return (int) $this->db->lastInsertId();
    }

    //update an existing book
    public function updateBook(int $id, string $title, string $author, string $description, ?string $cover, int $isAvailable): void
    {
        $sql = "UPDATE books
                SET title = :title, author = :author, description = :description, cover = :cover, is_available = :is_available
                WHERE id = :id";
        $this->db->query($sql, [
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'cover' => $cover,
            'is_available' => $isAvailable,
            'id' => $id,
        ]);
    }

    //delete a book by its id
    public function deleteBook(int $id): void
    {
        $this->db->query("DELETE FROM books WHERE id = :id", ['id' => $id]);
    }
}
