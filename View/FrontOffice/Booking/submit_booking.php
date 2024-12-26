<?php
require_once '../../../config.php';

// Create a new Database object and get the connection
$database = new Database();
$conn = $database->getConnection();

// Initialize variables and error messages
$name = $email = $destination = $date = '';
$id_trip = null;
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $destination = htmlspecialchars(trim($_POST['destination']));
    $date = htmlspecialchars(trim($_POST['date']));

    // Retrieve id_trip from POST data
    if (isset($_POST['id_trip'])) {
        $id_trip = intval($_POST['id_trip']);
    } else {
        $errors[] = "Trip ID is missing.";
    }

    // Server-side validation

    // Validate Full Name
    if (strlen($name) < 3) {
        $errors[] = "Full Name must be at least 3 characters long.";
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate Date of Travel
    $datePattern = "/^\d{4}-\d{2}-\d{2}$/";
    if (!preg_match($datePattern, $date)) {
        $errors[] = "Date of Travel must be in YYYY-MM-DD format.";
    }

    // Validate id_trip
    if (empty($id_trip)) {
        $errors[] = "Invalid Trip ID.";
    } else {
        // Verify id_trip exists in trips table
        $sql = "SELECT COUNT(*) FROM trips WHERE id = :id_trip";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_trip', $id_trip, PDO::PARAM_INT);
        $stmt->execute();
        $tripExists = $stmt->fetchColumn();
        if (!$tripExists) {
            $errors[] = "Selected trip does not exist.";
        }
    }

    // If no errors, proceed to insert into the database
    if (empty($errors)) {
        try {
            // Prepare an SQL statement
            $sql = "INSERT INTO bookings (name, email, destination, booking_date, id_trip) 
                    VALUES (:name, :email, :destination, :date, :id_trip)";
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':destination', $destination);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':id_trip', $id_trip, PDO::PARAM_INT);

            // Execute the statement
            if ($stmt->execute()) {
                // Success message or redirect
                echo "Booking successfully submitted!";
            } else {
                echo "Error: Could not execute the query.";
            }

        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
    }

    // Close the database connection
    $conn = null;
}
?>