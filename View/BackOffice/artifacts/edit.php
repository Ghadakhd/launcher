<?php
require_once '../../../controller/ArtifactController.php';
require_once '../../../controller/MuseumController.php';

$museumController = new MuseumController();
$museums = Museum::getAllMuseums();

$artifactController = new ArtifactController();
$artifact = $artifactController->getArtifactById($_GET['id']); // Fetch Artifact by ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare data from POST request
    $data = [
        'Name' => $_POST['Name'],
        'Type' => $_POST['Type'],
        'Era' => $_POST['Era'],
        'MuseumID' => $_POST['MuseumID'],
        'Description' => $_POST['Description'],
    ];

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $data['image'] = 'images/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../../' . $data['image']);
    } else {
        $data['image'] = $artifact['image']; // Retain old image if no new one
    }

    // Update Artifact data
    $artifactController->updateArtifact($_GET['id'], $data);

    // Redirect to the index page
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artifact</title>
    <link rel="stylesheet" href="../../../assets/css/form.css">
</head>
<body>
    <h1>Edit Artifact</h1>
    <form method="POST" enctype="multipart/form-data" id="editArtifactForm">
        <input type="hidden" name="id" value="<?= htmlspecialchars($artifact['ArtifactID']); ?>">

        <div class="form-group">
            <label for="Name">Name:</label>
            <input type="text" id="Name" name="Name" value="<?= htmlspecialchars($artifact['Name']); ?>" >
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="Type">Type:</label>
            <input type="text" id="Type" name="Type" value="<?= htmlspecialchars($artifact['Type']); ?>" >
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="Era">Era:</label>
            <input type="text" id="Era" name="Era" value="<?= htmlspecialchars($artifact['Era']); ?>" >
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
            <input type="text" id="Description" name="Description" value="<?= htmlspecialchars($artifact['Description']); ?>" >
            <span class="error"></span>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <div id="dropZone">
                <p>Drag and drop an image here or click to upload</p>
                <input type="file" id="imageInput" name="image" accept="image/*">
            </div>
            <?php if ($artifact['image']): ?>
                <img id="imagePreview" src="../../../<?= htmlspecialchars($artifact['image']); ?>" alt="Image Preview" style="max-width: 200px; margin-top: 10px;">
            <?php endif; ?>
            <span class="error"></span>
        </div>

        <button type="submit">Update Artifact</button>
    </form>

    <script src="../../../assets/js/drag-and-drop.js"></script>
    <script src="../../../assets/js/formartifactval.js"></script>
</body>
</html>
