<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Model/Artifact.php';

class ArtifactController {
    public function getArtifacts() {
        return Artifact::getAllArtifacts();
    }

    public function getArtifactById($id) {
        return Artifact::getArtifactById($id);
    }

    public function createArtifact($data) {
        return Artifact::createArtifact($data);
    }

    public function updateArtifact($id, $data) {
        return Artifact::updateArtifact($id, $data);
    }

    public function deleteArtifact($id) {
        return Artifact::deleteArtifact($id);
    }
    public function getArtifactsByMuseumId($museum_id) {
        // Create an instance of the Artifact class
        $artifact = new Artifact();
        // Call the instance method
        return $artifact->getArtifactsByMuseumId($museum_id);
    }
}
?>
