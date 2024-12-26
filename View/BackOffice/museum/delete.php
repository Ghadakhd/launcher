<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Controller/MuseumController.php';

if (isset($_GET['id'])) {
    $controller = new MuseumController();
    $controller->deleteMuseum($_GET['id']); // Delete museum by ID

    header('Location: index.php'); // Redirect to the list
    exit;
}
?>
