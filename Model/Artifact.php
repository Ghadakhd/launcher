<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Config.php';

class Artifact {
    public static function getAllArtifacts() {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT * FROM artifact");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getArtifactById($id) {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT * FROM artifact WHERE ArtifactID = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function createArtifact($data) {
        $db = Database::getConnection();
        $query = $db->prepare("INSERT INTO artifact (Name, Type, Era, MuseumID, image, Description) VALUES (?, ?, ?, ?, ?, ?)");
        return $query->execute([$data['Name'], $data['Type'], $data['Era'], $data['MuseumID'], $data['image'], $data['Description']]);
    }

    public static function updateArtifact($id, $data) {
        $db = Database::getConnection();
        $query = $db->prepare("UPDATE artifact SET Name = ?, Type = ?, Era = ?, MuseumID = ?, image = ?, Description=? WHERE ArtifactID = ?");
        return $query->execute([$data['Name'], $data['Type'], $data['Era'], $data['MuseumID'], $data['image'], $data['Description'], $id]);
    }

    public static function deleteArtifact($id) {
        $db = Database::getConnection();
        $query = $db->prepare("DELETE FROM artifact WHERE ArtifactID = ?");
        return $query->execute([$id]);
    }
    public function getArtifactsByMuseumId($museum_id) {
        $db = Database::getConnection();
        // Fetch all artifacts with the specific MuseumID
        $query = $db->prepare("SELECT * FROM artifact WHERE MuseumID = ?");
        $query->execute([$museum_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
