<?php

class Catalog {
    private $db;

    public function __construct() {
        $instance = Database::getInstance();
        $this->db = $instance->getConnection();
        
        if ($this->db === null) {
            die("Fatal Error: Catalog Model failed to retrieve Database connection.");
        }
    }

    /**
     * Link a file to a user's personal catalog.
     * Prevents duplicates using PostgreSQL ON CONFLICT logic.
     */
   public function addToFileCatalog($userId, $fileId, $folderId = null, $displayName = null) {
    $sql = "INSERT INTO catalog (user_id, document_id, folder_id, custom_display_name) 
            VALUES (:user_id, :document_id, :folder_id, :display_name)
            ON CONFLICT (user_id, document_id) 
            DO UPDATE SET last_viewed_at = CURRENT_TIMESTAMP";
    
    $stmt = $this->db->prepare($sql);
    
    return $stmt->execute([
        ':user_id'      => $userId,
        ':document_id'  => $fileId,
        ':folder_id'    => $folderId, 
        ':display_name' => $displayName
    ]);
}

    /**
     * Fetches every file owned/saved by the user for the "My Catalog" view.
     */
    public function findAllFilesByUserId($userId) {
        $sql = "SELECT c.*, d.title, d.file_path, d.description, d.tags 
                FROM catalog c
                JOIN documents d ON c.document_id = d.id
                WHERE c.user_id = :user_id
                ORDER BY c.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}