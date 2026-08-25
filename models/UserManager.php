<?php

//manager for the users table
class UserManager extends AbstractEntityManager
{
    //get one user by his id
    public function getUserById(int $id): ?User
    {
        $sql = "SELECT id, username, email, password, created_at FROM users WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $user = $result->fetch();

        if ($user) {
            return new User($user);
        }
        return null;
    }

    //get one user by his email
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT id, username, email, password, created_at FROM users WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();

        if ($user) {
            return new User($user);
        }
        return null;
    }

    //get one user by his username
    public function getUserByUsername(string $username): ?User
    {
        $sql = "SELECT id, username, email, password, created_at FROM users WHERE username = :username";
        $result = $this->db->query($sql, ['username' => $username]);
        $user = $result->fetch();

        if ($user) {
            return new User($user);
        }
        return null;
    }

    //create a new user and return his id
    public function createUser(string $username, string $email, string $password): int
    {
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $this->db->query($sql, [
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ]);

        return (int) $this->db->lastInsertId();
    }
}
