<?php

class Mail
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /*
     * Send mail
     */
    public function send(
        int $senderId,
        int $receiverId,
        string $subject,
        string $body,
        ?int $parentMailId = null
    ): bool {
        $sql = "
            INSERT INTO mails
            (
                sender_id,
                receiver_id,
                subject,
                body,
                parent_mail_id
            )
            VALUES
            (
                :sender_id,
                :receiver_id,
                :subject,
                :body,
                :parent_mail_id
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'subject' => $subject,
            'body' => $body,
            'parent_mail_id' => $parentMailId
        ]);
    }

    /*
     * Inbox
     */
    public function getInbox(
        int $userId
    ): array {
        $sql = "
            SELECT
                m.*,
                u.name AS sender_name,
                u.email AS sender_email
            FROM mails m
            JOIN users u
                ON u.id = m.sender_id
            WHERE m.receiver_id = :user_id
            ORDER BY m.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    /*
     * Sent mail
     */
    public function getSent(
        int $userId
    ): array {
        $sql = "
            SELECT
                m.*,
                u.name AS receiver_name,
                u.email AS receiver_email
            FROM mails m
            JOIN users u
                ON u.id = m.receiver_id
            WHERE m.sender_id = :user_id
            ORDER BY m.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    /*
     * Get one mail
     */
    public function getById(
        int $id
    ): ?array {
        $stmt = $this->db->prepare(
            "SELECT * FROM mails WHERE id = :id"
        );

        $stmt->execute([
            'id' => $id
        ]);

        $mail = $stmt->fetch();

        return $mail ?: null;
    }

    /*
     * Mark as read
     */
    public function markAsRead(int $id): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE mails SET is_read = 1 WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
