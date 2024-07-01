<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'genzs');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Gather form data
    $title = $conn->real_escape_string($_POST['ad-title']);
    $category = $conn->real_escape_string($_POST['category']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $location = $conn->real_escape_string($_POST['location']);
    $contact_name = $conn->real_escape_string($_POST['contact-name']);
    $contact_email = $conn->real_escape_string($_POST['contact-email']);
    $contact_phone = $conn->real_escape_string($_POST['contact-phone']);

    // Handle file upload
    $images = [];
    foreach ($_FILES['images']['name'] as $key => $name) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['images']['name'][$key]);
        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
            $images[] = $target_file;
        }
    }
    $images_serialized = serialize($images);

    // Insert ad into database with status 'pending'
    $sql = "INSERT INTO ads (title, category, description, price, location, images, contact_name, contact_email, contact_phone, status) VALUES ('$title', '$category', '$description', '$price', '$location', '$images_serialized', '$contact_name', '$contact_email', '$contact_phone', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "Ad submitted successfully! It will be reviewed by an admin shortly.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
