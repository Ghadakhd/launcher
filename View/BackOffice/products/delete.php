<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/controller/ProductController.php';

if (isset($_GET['id'])) {
    $productController = new ProductController();
    $productController->deleteProduct($_GET['id']);
    header('Location: index.php');
    exit;
}
?>
