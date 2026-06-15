<?php

class User
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /*
     * Create user
     */
    public function create(
        string $name,
        string $email,
        string $password
    ): bool
    {
        $hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "
            INSERT INTO users
            (
                name,
                email,
                password
            )
            VALUES
            (
                :name,
                :email,
                :password
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hash
        ]);
    }

    /*
     * Get user by email
     */
    public function findByEmail(
        string $email
    ): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :email"
        );

        $stmt->execute([
            'email' => $email
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    /*
     * Get user by id
     */
    public function findById(
        int $id
    ): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE id = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    /*
     * Verify credentials
     */
    public function login(
        string $email,
        string $password
    ): ?array
    {
        $user = $this->findByEmail(
            $email
        );

        if (
            $user &&
            password_verify(
                $password,
                $user['password']
            )
        )
        {
            return $user;
        }

        return null;
    }
}