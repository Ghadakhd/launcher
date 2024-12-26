<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Controller/ArtifactController.php';
require_once '../../../controller/MuseumController.php';

$museumController = new MuseumController();
$museums = Museum::getAllMuseums();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare Artifact data
    $data = [
        'Name' => $_POST['Name'],
        'Type' => $_POST['Type'],
        'Era' => $_POST['Era'],
        'MuseumID' => $_POST['MuseumID'],
        'Description' => $_POST['Description'],
        'image' => 'images/' . $_FILES['image']['name'],
    ];

    // Move the uploaded image to the images directory
    move_uploaded_file($_FILES['image']['tmp_name'],  $data['image']);

    // Create Artifact in the database
    $controller = new ArtifactController();
    $controller->createArtifact($data);

    // Redirect to the Artifact list
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Artifact</title>
    <link rel="stylesheet" href="../../../assets/css/form.css">
</head>
<body>
    <h1>Add New Artifact</h1>
    <form method="POST" enctype="multipart/form-data" id="createArtifactForm">
        <div class="form-group">
            <label for="Name">Name:</label>
            <input type="text" id="Name" name="Name">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="Type">Type:</label>
            <input type="text" id="Type" name="Type">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="Era">Era:</label>
            <input type="text" id="Era" name="Era">
            <span class="error"></span>
        </div>

        <div class="form-group">
             <label for="MuseumID">Museum:</label>
            <select id="MuseumID" name="MuseumID" required>
            <option value="" disabled selected>Select a Museum</option>
            <?php foreach ($museums as $museum): ?>
            <option value="<?php echo $museum['id']; ?>">
                <?php echo htmlspecialchars($museum['name'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
           <?php endforeach; ?>
             </select>
             <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="Description">Description:</label>
            <input type="text" id="Description" name="Description">
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <div id="dropZone">
                <p>Drag and drop an image here or click to upload</p>
                <input type="file" id="imageInput" name="image" accept="image/*">
            </div>
            <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 200px; margin-top: 10px;">
            <span class="error"></span>
        </div>

        <button type="submit">Add Artifact</button>
    </form>

    <script src="../../../assets/js/formartifactval.js"></script>
</body>
</html>
