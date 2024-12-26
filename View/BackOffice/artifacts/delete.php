<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Controller/ArtifactController.php';

if (isset($_GET['id'])) {
    $controller = new ArtifactController();
    $controller->deleteArtifact($_GET['id']); // Delete Artifact by ID

    header('Location: index.php'); // Redirect to the list
    exit;
}
?>
