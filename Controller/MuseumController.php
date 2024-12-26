<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Model/Museum.php';

class MuseumController {
    public function getMuseums() {
        return Museum::getAllMuseums();
    }

    public function getMuseumById($id) {
        return Museum::getMuseumById($id);
    }

    public function createMuseum($data) {
        return Museum::createMuseum($data);
    }

    public function updateMuseum($id, $data) {
        return Museum::updateMuseum($id, $data);
    }

    public function deleteMuseum($id) {
        return Museum::deleteMuseum($id);
    }
}
?>
