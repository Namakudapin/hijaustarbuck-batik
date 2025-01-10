<?php
require_once __DIR__ . '/../../../controllers/NewsController.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $newsController = new NewsController();

    $newsController->destroy($id);
    header('Location: info.php');
    exit;
} else {
    header('Location: index.php?status=error');
    exit;
}
?>
