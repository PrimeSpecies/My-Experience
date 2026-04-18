<?php
namespace App\Controllers;

use App\Services\FileService;
use Document;

class DocumentController {
    private $fileService;
    private $documentModel;

    public function __construct() {
        $this->fileService = new FileService();
        $this->documentModel = new Document();
    }

    public function bookmark() {
        header('Content-Type: application/json');

        // Bookmark is triggered via GET in your current setup
        if (isset($_GET['id'])) {
            $userId = $_SESSION['user_id'] ?? null;
            $fileId = $_GET['id'];

            if (!$userId) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Unauthorized: User not logged in.']);
                exit;
            }

         try {
    $success = $this->fileService->bookmarkToCatalog($userId, $fileId);
    if ($success) {
        // Redirect with a success flag
        header("Location: index.php?action=dashboard&msg=success");
        exit;
    }
} catch (\Exception $e) {
    header("Location: index.php?action=dashboard&msg=error");
    exit;
}
            }
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid request: Missing document ID.']);
        exit;
    }

    public function upload() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
            $userId = $_SESSION['user_id'] ?? 1; 

            $metadata = [
                'title'       => !empty($_POST['title']) ? $_POST['title'] : $_FILES['document']['name'],
                'description' => $_POST['description'] ?? '',
                'tags'        => $_POST['tags'] ?? '',
                'is_public'   => ($_POST['is_public'] === '1' || $_POST['is_public'] === 'true'),
                'folder_id'   => !empty($_POST['folder_id']) ? (int)$_POST['folder_id'] : null
            ];
            
            try {
                $fileId = $this->fileService->store($_FILES['document'], $userId, $metadata);

                if ($fileId) {
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Research indexed successfully',
                        'document_id' => $fileId
                    ]);
                } else {
                    throw new \Exception('Service layer failed to store document.');
                }
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'success' => false, 
                    'message' => $e->getMessage()
                ]);
            }
            exit;
        }

        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid request or no file received.']);
        exit;
    }
}