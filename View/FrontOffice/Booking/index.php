<?php
// index.php

// Include the database configuration file
require_once '../../../config.php';
include_once "../../../Controller/TripController.php";

// Create a new Database object and get the connection
$database = new Database();
$conn = $database->getConnection();

// Initialize variables
$search_query = '';
$trips = [];

// Trip of the Week
$tripController = new TripController();
$tripController->updateTripPopularity();
$tripOfTheWeek = $tripController->getTripOfTheWeek();

// Check if the search form has been submitted
if (isset($_GET['search_query']) && !empty(trim($_GET['search_query']))) {
    // Get the search query and sanitize it
    $search_query = trim($_GET['search_query']);

    // Prepare and execute the query with search functionality
    $query = "SELECT id, destination, image FROM trips WHERE destination LIKE :search_query";
    $stmt = $conn->prepare($query);
    $like_search_query = '%' . $search_query . '%';
    $stmt->bindParam(':search_query', $like_search_query);
} else {
    // If no search query, select all trips
    $query = "SELECT id, destination, image FROM trips";
    $stmt = $conn->prepare($query);
}

// Execute the query
$stmt->execute();
$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Explore Tunisian Heritage</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Search Bar Styling */
        .search-bar {
            text-align: center;
            margin: 20px 20px;
        }

        .search-bar form {
            display: inline-block;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #8B5A2B;
            border-radius: 5px;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: #8B5A2B;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #A0522D;
        }

        /* Gallery Styling */
        .gallery {
            text-align: center;
            margin: 40px 20px;
        }

        .gallery-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .gallery-item {
            flex: 0 0 300px;
            margin: 10px;
        }

        .gallery-item img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .gallery-item p {
            font-size: 1.1em;
            color: #333;
        }

        /* Trip of the Week Styling */
        .trip-of-the-week {
            text-align: center;
            margin: 20px 10px;
            padding: 10px;
            border: 1px solid #8B5A2B;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .trip-of-the-week img {
            max-width: 80%;
            height: auto;
            border-radius: 5px;
        }

        .trip-of-the-week h2 {
            font-size: 1.5em;
            color: #8B5A2B;
        }

        .trip-of-the-week p {
            font-size: 1em;
            color: #333;
        }
        .chatbot-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #3498db; /* Team's button color */
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .chatbot-button:hover {
        background-color: #2980b9;
        transform: scale(1.1);
        }
        h1,h2,p{
            color:white;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <h1>Discover Tunisia's Heritage</h1>
        <p>Explore the beautiful monuments and galleries of Tunisia</p>
    </div>

    <!-- Trip of the Week Section -->
    <?php if ($tripOfTheWeek): ?>
    <div class="trip-of-the-week">
        <h2>Trip of the Week</h2>
        <img src="data:image/jpeg;base64,<?= base64_encode($tripOfTheWeek['image']) ?>" alt="<?= htmlspecialchars($tripOfTheWeek['destination']) ?>">
        <p>Destination: <?= htmlspecialchars($tripOfTheWeek['destination']) ?></p>
        <p>Popularity: <?= number_format($tripOfTheWeek['popularity'], 2) ?>%</p>
    </div>
    <?php endif; ?>

    <!-- Search Form -->
    <div class="search-bar">
        <form method="GET" action="index.php">
            <input type="text" name="search_query" placeholder="Search for a trip..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Gallery Section -->
    <div class="gallery">
        <?php if (!empty($search_query)): ?>
            <h2>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
        <?php else: ?>
            <h2>All Trips</h2>
        <?php endif; ?>
        <div class="gallery-grid">
            <?php if (!empty($trips)): ?>
                <?php
                // Loop through each trip and display it
                foreach ($trips as $trip):
                    // Encode the image data
                    $imageData = base64_encode($trip['image']);
                ?>
                <div class="gallery-item">
                    <a href="booking.html?destination=<?php echo urlencode($trip['destination']); ?>&id_trip=<?php echo $trip['id']; ?>">
                        <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="<?php echo htmlspecialchars($trip['destination']); ?>">
                        <p><?php echo htmlspecialchars($trip['destination']); ?></p>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No trips found matching your search.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2024 Tunisia Heritage Preservation. All rights reserved.</p>
    </div>
    <button id="chatbot-button" class="chatbot-button">
        <span>💬</span>
    </button>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
  // Chatbot Button Logic
  const chatbotButton = document.getElementById("chatbot-button");

  if (chatbotButton) {
    chatbotButton.addEventListener("click", () => {
      window.open(
        "https://tun-108725.zapier.app", // URL to open
        "ChatBotWindow", // A unique name for the window
        "width=800,height=600,top=100,left=100,noopener,noreferrer" // Added security features
      );
    });
  }
    });
    </script>
</html>
