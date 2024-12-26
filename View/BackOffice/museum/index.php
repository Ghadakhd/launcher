<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Controller/MuseumController.php';

$controller = new MuseumController();
$museums = $controller->getMuseums();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Museums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="text-center">Manage Museums</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 text-end">
                <a href="create.php" class="btn btn-primary">Add New Museum</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($museums)): ?>
                            <?php foreach ($museums as $museum): ?>
                                <tr>
                                    <td><?php echo $museum['id']; ?></td>
                                    <td><?php echo htmlspecialchars($museum['name']); ?></td>
                                    <td><?php echo htmlspecialchars($museum['description']); ?></td>
                                    <td>
                                        <img 
                                            src="<?php echo htmlspecialchars($museum['image']); ?>" 
                                            alt="Image" 
                                            class="img-thumbnail" 
                                            style="width: 80px;">
                                    </td>
                                    <td><?php echo htmlspecialchars($museum['location']); ?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $museum['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="delete.php?id=<?php echo $museum['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No museums found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
