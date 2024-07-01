<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'genzs');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved ads
$result = $conn->query("SELECT * FROM ads WHERE status='approved'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ads</title>
    <style>
        /* Your CSS styles for displaying ads */
    </style>
</head>
<body>
    <h1>Approved Ads</h1>
    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
            <li>
                <h2><?= htmlspecialchars($row['title']) ?></h2>
                <p>Category: <?= htmlspecialchars($row['category']) ?></p>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p>Price: <?= htmlspecialchars($row['price']) ?></p>
                <p>Location: <?= htmlspecialchars($row['location']) ?></p>
                <p>Contact: <?= htmlspecialchars($row['contact_name']) ?> - <?= htmlspecialchars($row['contact_email']) ?> - <?= htmlspecialchars($row['contact_phone']) ?></p>
                <div>
                    <?php
                    $images = unserialize($row['images']);
                    foreach ($images as $image) {
                        echo "<img src='".htmlspecialchars($image)."' alt='Image' width='100'>";
                    }
                    ?>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

<?php
$conn->close();
?>
