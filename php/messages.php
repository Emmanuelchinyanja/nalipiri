<?php
class Messages {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }
    public function getMessages($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM message WHERE customer_id = :customer_id");
        $stmt->bindParam(':customer_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>