<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Config.php';

class Museum {
    public static function getAllMuseums() {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT * FROM museums");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getMuseumById($id) {
        $db = Database::getConnection();
        $query = $db->prepare("SELECT * FROM museums WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function createMuseum($data) {
        $db = Database::getConnection();
        $query = $db->prepare("INSERT INTO museums (name, description, image, location) VALUES (?, ?, ?, ?)");
        return $query->execute([$data['name'], $data['description'], $data['image'], $data['location']]);
    }

    public static function updateMuseum($id, $data) {
        $db = Database::getConnection();
        $query = $db->prepare("UPDATE museums SET name = ?, description = ?, image = ?, location = ? WHERE id = ?");
        return $query->execute([$data['name'], $data['description'], $data['image'], $data['location'], $id]);
    }

    public static function deleteMuseum($id) {
        $db = Database::getConnection();
        $query = $db->prepare("DELETE FROM museums WHERE id = ?");
        return $query->execute([$id]);
    }
}
?>
