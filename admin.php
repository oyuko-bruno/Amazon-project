<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'genzs');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Approve ad
if (isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    $conn->query("UPDATE ads SET status='approved' WHERE id=$id");
}

// Fetch pending ads
$result = $conn->query("SELECT * FROM ads WHERE status='pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        /* Your CSS styles for the admin panel */
    </style>
</head>
<body>
    <h1>Pending Ads</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Location</th>
                <th>Contact</th>
                <th>Images</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['price']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= htmlspecialchars($row['contact_name']) ?><br><?= htmlspecialchars($row['contact_email']) ?><br><?= htmlspecialchars($row['contact_phone']) ?></td>
                    <td>
                        <?php
                        $images = unserialize($row['images']);
                        foreach ($images as $image) {
                            echo "<img src='".htmlspecialchars($image)."' alt='Image' width='100'>";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="admin.php?approve=<?= $row['id'] ?>">Approve</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
