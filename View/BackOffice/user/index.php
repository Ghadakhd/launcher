<?php
// Default page
$page = isset($_GET['page']) ? $_GET['page'] : 'list_users';

// Include the appropriate page based on the `page` query parameter
switch ($page) {
    case 'process_user':
        require_once __DIR__ . '/process_user.php';
        break;
    case 'list_users':
    default:
        require_once __DIR__ . '/list_users.php';
        break;
}
?>
