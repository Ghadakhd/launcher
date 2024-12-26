<?php

$host = 'localhost'; // Database host
$dbname = 'tunivers'; // Your database name
$username = 'root'; // Default username for XAMPP/WAMP
$password = ''; // Default password is empty for XAMPP/WAMP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}



// Function to handle image uploads
function handleImageUpload($image) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    // Validate file type
    if (!in_array($image['type'], $allowedTypes)) {
        return false; // Invalid file type
    }

    // Validate file size
    if ($image['size'] > $maxFileSize) {
        return false; // File too large
    }

    $imageName = $image['name'];
    $imagePath = 'uploaded_img/' . $imageName;

    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
        return $imageName;
    } else {
        return false;
    }
}

// Fetching statistics (Total Monuments and Suggestions)
if (isset($_GET['action']) && $_GET['action'] === 'statistics') {
    try {
        // Query to get total monuments
        $queryMonuments = "SELECT COUNT(*) AS totalMonuments FROM monuments";
        $stmtMonuments = $pdo->query($queryMonuments);
        $totalMonuments = $stmtMonuments->fetch(PDO::FETCH_ASSOC)['totalMonuments'];

        // Query to get total suggestions
        $querySuggestions = "SELECT COUNT(*) AS totalSuggestions FROM suggestions";
        $stmtSuggestions = $pdo->query($querySuggestions);
        $totalSuggestions = $stmtSuggestions->fetch(PDO::FETCH_ASSOC)['totalSuggestions'];

        // Return statistics as JSON
        echo json_encode([
            'totalMonuments' => $totalMonuments,
            'totalSuggestions' => $totalSuggestions
        ]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error fetching statistics: " . $e->getMessage()]);
    }
    exit;
}

// Fetching all monuments (Read operation)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['monumentId']) && !isset($_GET['suggestionId'])) {
    try {
        $query = "SELECT * FROM monuments";
        $stmt = $pdo->query($query);
        $monuments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($monuments);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error fetching monuments: " . $e->getMessage()]);
    }
}

// Fetching suggestions for a specific monument (Read operation)
if (isset($_GET['monumentId']) && !isset($_GET['suggestionId'])) {
    try {
        $monumentId = $_GET['monumentId'];
        $query = "SELECT id, monument_id, name, suggestion, image FROM suggestions WHERE monument_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$monumentId]);
        $suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($suggestions);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error fetching suggestions: " . $e->getMessage()]);
    }
}

// Fetching a specific suggestion (Read operation)
if (isset($_GET['suggestionId']) && !isset($_GET['monumentId'])) {
    try {
        $suggestionId = $_GET['suggestionId'];
        $query = "SELECT id, monument_id, name, suggestion, image FROM suggestions WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$suggestionId]);
        $suggestion = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($suggestion);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error fetching suggestion: " . $e->getMessage()]);
    }
}

// Adding a new monument (Create operation)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['_method']) && !isset($_POST['suggestion']) && !isset($_POST['name'])) {
    try {
        $title = $_POST['title'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $region = $_POST['region'];
        $image = $_FILES['image'];

        $imageName = handleImageUpload($image);
        if (!$imageName) {
            echo json_encode(["error" => "Invalid image file."]);
            exit;
        }

        $query = "INSERT INTO monuments (title, location, description, image, region) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $location, $description, $imageName, $region]);

        echo json_encode(["message" => "Monument added successfully!"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error adding monument: " . $e->getMessage()]);
    }
}

// Adding a new suggestion for a monument (Create operation)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['suggestion']) && isset($_POST['monumentId']) && isset($_POST['name'])) {
    try {
        $suggestionText = $_POST['suggestion'];
        $monumentId = $_POST['monumentId'];
        $name = $_POST['name'];
        $image = $_FILES['image'];

        $imageName = handleImageUpload($image);
        if (!$imageName) {
            echo json_encode(["error" => "Invalid image file."]);
            exit;
        }

        $query = "INSERT INTO suggestions (monument_id, name, suggestion, image) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$monumentId, $name, $suggestionText, $imageName]);

        echo json_encode(["message" => "Suggestion added successfully!"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error adding suggestion: " . $e->getMessage()]);
    }
}

// Updating a monument (Update operation)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT' && !isset($_POST['suggestion']) && !isset($_POST['name'])) {
    try {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $region = $_POST['region'];
        $image = $_FILES['image'];

        // Handle image upload (only if a new image is provided)
        if ($image['name']) {
            $imageName = handleImageUpload($image);
            if (!$imageName) {
                echo json_encode(["error" => "Invalid image file."]);
                exit;
            }
        } else {
            $imageName = $_POST['existingImage']; // Use the existing image if no new one is uploaded
        }

        $query = "UPDATE monuments SET title = ?, location = ?, description = ?, region = ?, image = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $location, $description, $region, $imageName, $id]);

        echo json_encode(["message" => "Monument updated successfully!"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error updating monument: " . $e->getMessage()]);
    }
}

// Updating a suggestion (Update operation)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT' && isset($_POST['suggestion']) && isset($_POST['monumentId']) && isset($_POST['name'])) {
    try {
        $suggestionId = $_POST['id'];
        $suggestionText = $_POST['suggestion'];
        $monumentId = $_POST['monumentId'];
        $name = $_POST['name'];
        $image = $_FILES['image'];

        // Handle image upload (only if a new image is provided)
        if ($image['name']) {
            $imageName = handleImageUpload($image);
            if (!$imageName) {
                echo json_encode(["error" => "Invalid image file."]);
                exit;
            }
        } else {
            $imageName = $_POST['existingImage']; // Use the existing image if no new one is uploaded
        }

        $query = "UPDATE suggestions SET name = ?, suggestion = ?, image = ? WHERE id = ? AND monument_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $suggestionText, $imageName, $suggestionId, $monumentId]);

        echo json_encode(["message" => "Suggestion updated successfully!"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error updating suggestion: " . $e->getMessage()]);
    }
}

// Deleting a monument (Delete operation)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id']) && !isset($_GET['suggestionId'])) {
    try {
        $id = $_GET['id'];
        
        // First delete any related suggestions for this monument
        $query = "DELETE FROM suggestions WHERE monument_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        // Then delete the monument itself
        $query = "DELETE FROM monuments WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);

        echo json_encode(["message" => "Monument and related suggestions deleted successfully!"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error deleting monument: " . $e->getMessage()]);
    }
}

// Deleting a suggestion (Delete operation)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['suggestionId']) && !isset($_GET['monumentId'])) {
    try {
        $suggestionId = $_GET['suggestionId'];

        $query = "DELETE FROM suggestions WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$suggestionId]);

        echo json_encode(["message" => "Suggestion deleted successfully!"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error deleting suggestion: " . $e->getMessage()]);
    }
}
?>
