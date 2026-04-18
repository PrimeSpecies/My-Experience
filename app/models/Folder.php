<?php

class Folder {
    private $db;

    public function __construct() {
        $instance = Database::getInstance();
        $this->db = $instance->getConnection();
        
        if ($this->db === null) {
            die("Fatal Error: Folder Model failed to retrieve Database connection.");
        }
    }

    /**
     * Create a new folder
     */
    public function create($name, $userId, $parentId = null) {
        $sql = "INSERT INTO folders (name, user_id, parent_id) 
                VALUES (:name, :user_id, :parent_id)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':name'      => $name,
            ':user_id'   => $userId,
            ':parent_id' => $parentId // NULL means it's a root folder
        ]);
    }

    /**
     * Get all folders for a specific user to build the sidebar tree
     */
    public function findByUser($userId) {
        $sql = "SELECT * FROM folders WHERE user_id = :user_id ORDER BY name ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        return $stmt->fetchAll();
    }

    /**
     * Get subfolders of a specific folder
     */
    public function getSubfolders($userId, $parentId) {
        $sql = "SELECT * FROM folders WHERE user_id = :user_id AND parent_id = :parent_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id'   => $userId, 
            ':parent_id' => $parentId
        ]);
        
        return $stmt->fetchAll();
    }

    /**
     * Delete a folder (Database constraint CASCADE will handle subfolders/files)
     */
    public function delete($id, $userId) {
        $sql = "DELETE FROM folders WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'      => $id,
            ':user_id' => $userId
        ]);
    }
}