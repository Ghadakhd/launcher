<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Model/order.php';

class OrderController {
    public function getAllOrders() {
        return Order::getAllOrders();
    }

    public function getOrderById($id) {
        return Order::getOrderById($id);
    }

    public function createOrder($data) {
        return Order::createOrder($data);
    }

    public function updateOrder($id, $data) {
        return Order::updateOrder($id, $data);
    }

    public function updateOrderStatus($id, $status) {
        return Order::updateStatus($id, $status);
    }

    public function deleteOrder($id) {
        return Order::deleteOrder($id);
    }
    
}
?>
