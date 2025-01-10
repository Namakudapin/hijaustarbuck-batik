<?php
// delete.php
require_once '../../../controllers/PaketController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $paketController = new PaketController();
        $id = intval($_POST['id']);
        $paketController->delete($id);
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Package deleted successfully']);
        
    } catch (Exception $e) {
        error_log("Delete Error: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to delete package']);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}