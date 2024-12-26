<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Controller/ArtifactController.php';

// Initialize the controller and fetch all artifacts
$controller = new ArtifactController();
$artifacts = $controller->getArtifacts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice: Manage Artifacts</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center">Artifact Management</h1>
            </div>
        </div>

        <!-- Add New Artifact Button -->
        <div class="row mb-3">
            <div class="col-12 text-end">
                <a href="create.php" class="btn btn-primary">Add New Artifact</a>
            </div>
        </div>

        <!-- Artifacts Table -->
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Era</th>
                            <th>Museum ID</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($artifacts)): ?>
                            <!-- Loop through artifacts -->
                            <?php foreach ($artifacts as $artifact): ?>
                                <tr>
                                    <td><?php echo $artifact['ArtifactID']; ?></td>
                                    <td><?php echo htmlspecialchars($artifact['Name']); ?></td>
                                    <td><?php echo htmlspecialchars($artifact['Type']); ?></td>
                                    <td><?php echo htmlspecialchars($artifact['Era']); ?></td>
                                    <td><?php echo htmlspecialchars($artifact['MuseumID']); ?></td>
                                    <td><?php echo htmlspecialchars($artifact['Description']); ?></td>
                                    <td>
                                        <img 
                                            src="<?php echo htmlspecialchars($artifact['image']); ?>" 
                                            alt="Artifact Image" 
                                            class="img-thumbnail" 
                                            style="width: 80px; height: auto;">
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $artifact['ArtifactID']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="delete.php?id=<?php echo $artifact['ArtifactID']; ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this artifact?');">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- No artifacts found -->
                            <tr>
                                <td colspan="7" class="text-center">No artifacts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
