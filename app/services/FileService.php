<?php
namespace App\Services;

use Document;
use Catalog;

class FileService {
    private $documentModel;
    private $catalogModel;

    public function __construct() {
        $this->documentModel = new Document();
        $this->catalogModel = new Catalog();
    }

    public function store($file, $userId, $metadata = []) {
        // 1. Path Management
        $baseDir = dirname(__DIR__, 2); 
        // Ensure storage path is consistent with your Nginx config
        $uploadDir = $baseDir . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR;

        if (!is_dir($uploadDir)) {
            // Using 0755 is generally safer than 0777 on Linux if Nginx owns the parent
            mkdir($uploadDir, 0755, true);
        }

        // 2. Cryptographic Filename (Prevents enumeration attacks)
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $hashedName = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = $uploadDir . $hashedName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            
            // 3. Normalize Boolean for PostgreSQL
            $isPublic = ($metadata['is_public'] === true || $metadata['is_public'] === 1 || $metadata['is_public'] === '1');

            // 4. Create record in 'documents' table
           $fileId = $this->documentModel->create([
    'user_id'     => $userId,
    'file_path'   => $destination,
    'title'       => $metadata['title'],
    'is_public'   => $isPublic,
    'description' => $metadata['description'] ?? '',
    'tags'        => $metadata['tags'] ?? '',
    'folder_id'   => $metadata['folder_id'] ?? null
]);

            if ($fileId) {
                // 5. Link to 'catalog' (Handles your "In Folder" logic)
                $folderId = (!empty($metadata['folder_id'])) ? (int)$metadata['folder_id'] : null;
                
                // We pass the display title here too so the catalog reflects the renamed version if changed
                $this->catalogModel->addToFileCatalog($userId, $fileId, $folderId, $metadata['title']);
                
                return $fileId;
            }
        }
        
        return false;
    }
    public function bookmarkToCatalog($userId, $fileId) {
    // 1. Get the document metadata using the Document Model
    // This is exactly how you handle metadata in the store() function
    $file = $this->documentModel->findById($fileId);

    if (!$file) {
        throw new \Exception('Document does not exist in the library.');
    }

    // 2. Delegate to the Catalog Model 
    // This matches: $this->catalogModel->addToFileCatalog(...) in your store() function
    // We pass null for folder_id since a bookmark is usually root-level unless specified
    $folderId = null; 
    
    $success = $this->catalogModel->addToFileCatalog(
        $userId, 
        $fileId, 
        $folderId, 
        $file['title']
    );

    return $success;
}
}