<?php

class Document {
    private $db;

    public function __construct() {
        $instance = Database::getInstance();
        $this->db = $instance->getConnection();
        
        if ($this->db === null) {
            die("Fatal Error: Document Model failed to retrieve Database connection.");
        }
    }

    /**
     * Create the master record for a file and return its ID
     */
    public function create($data) {
        // Updated table name to 'documents'
        $sql = "INSERT INTO documents (user_id, title, description, tags, is_public, file_path, folder_id) 
                VALUES (:user_id, :title, :description, :tags, :is_public, :file_path, :folder_id)
                RETURNING id"; // Required for PostgreSQL to get the new ID
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id'     => $data['user_id'],
                ':title'       => $data['title'],
                ':description' => $data['description'],
                ':tags'        => $data['tags'],
                ':is_public'   => $data['is_public'] ? 'true' : 'false',
                ':file_path'   => $data['file_path'],
                ':folder_id'   => $data['folder_id']
            ]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'] ?? false;
        } catch (PDOException $e) {
            error_log("Document Create Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get recent public files for Global Discovery
     */
    public function getLatestPublic() {
        // Updated table name to 'documents' and column 'user_id'
        $sql = "SELECT d.*, u.username 
                FROM documents d 
                JOIN users u ON d.user_id = u.id 
                WHERE d.is_public = TRUE 
                ORDER BY d.uploaded_at DESC 
                LIMIT 10";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM documents WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}