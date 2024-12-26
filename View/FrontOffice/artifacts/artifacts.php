<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/launcher/Controller/ArtifactController.php';

// Get the museum_id from the URL parameter
$museum_id = isset($_GET['id']) ? $_GET['id'] : null;

// Initialize the controller and fetch artifacts based on the museum_id

$controller = new ArtifactController();
$artifacts = $controller->getArtifactsByMuseumId($museum_id);
$types = array_unique(array_column($artifacts, 'Type'));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artifacts and Displays</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <!-- Optional header content -->
    </header>
    <main>
        <section class="servics" id="servics">
            <div class="container">
                <div class="section-title">
                    <h2>Artifacts and Displays</h2>
                    <p>Discover fascinating artifacts and explore rich histories through our curated exhibits.</p>
                </div>

                <!-- Filter by Type -->
                <div id="filter-container">
                    <select id="typeFilter">
                        <option value="all">All Types</option>
                        <?php foreach ($types as $type): ?>
                            <option value="<?= htmlspecialchars($type); ?>"><?= htmlspecialchars($type); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Artifacts List -->
                <ul id="artifacts-list" class="cards">
                    <?php if (!empty($artifacts)): ?>
                        <?php foreach ($artifacts as $artifact): ?>
                            <li class="card" data-type="<?= htmlspecialchars($artifact['Type'] ?? 'Unknown'); ?>">
                                <img src="<?= htmlspecialchars($artifact['image'] ?? 'default.jpg'); ?>" alt="<?= htmlspecialchars($artifact['Name'] ?? 'Unknown Artifact'); ?>">
                                <h3><?= htmlspecialchars($artifact['Name'] ?? 'No Name'); ?></h3>
                                <p>Type: <?= htmlspecialchars($artifact['Type'] ?? 'Unknown Type'); ?> | Era: <?= htmlspecialchars($artifact['Era'] ?? 'Unknown Era'); ?></p>
                                <p><?= htmlspecialchars($artifact['Description'] ?? 'No Description'); ?></p>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="card">
                            <p>No artifacts available for this museum.</p>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    </main>

    <script>
        // Filter Artifacts by Type
        const typeFilter = document.getElementById('typeFilter');
        const artifactCards = document.querySelectorAll('#artifacts-list .card');

        typeFilter.addEventListener('change', function() {
            const selectedType = this.value;

            artifactCards.forEach(card => {
                const cardType = card.getAttribute('data-type');

                if (selectedType === 'all' || cardType === selectedType) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
