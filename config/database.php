<?php

class Database
{
    private string $host = "localhost";

    private string $database = "email_client";

    private string $username = "root";

    private string $password = "";

    private PDO $connection;

    public function connect(): PDO
    {
        if (!isset($this->connection)) {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->connection->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );
        }

        return $this->connection;
    }
}
