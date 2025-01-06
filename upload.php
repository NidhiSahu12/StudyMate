<?php
include 'db.php';

// Suppress all PHP warnings and notices
error_reporting(0);

// Variable to store messages
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form inputs
    $branch_id = $_POST['branch'];
    $subject_id = $_POST['subject'];
    $user_id = 1; // Replace with session user ID

    // Check if a file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $filename = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $upload_dir = "uploaded/";
        $file_path = $upload_dir . basename($filename);

        // Attempt to move the uploaded file
        if (@move_uploaded_file($file_tmp, $file_path)) {
            // Insert file details into the database
            $sql = "INSERT INTO files (user_id, subject_id, filename, status) VALUES ('$user_id', '$subject_id', '$filename', 'pending')";
            if ($conn->query($sql) === TRUE) {
                $errorMessage = "<p style='color: green;'>File uploaded successfully!</p>";
            } else {
                $errorMessage = "<p style='color: red;'>Failed to save file details in the database.</p>";
            }
        } else {
            $errorMessage = "<p style='color: red;'>Failed to upload file. Please try again.</p>";
        }
    } else {
        $errorMessage = "<p style='color: red;'>Failed to upload file. Please ensure a valid file is selected.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link rel="stylesheet" href="upload_file.css">
</head>
<body>
    <div class="container">
        <h2>Upload File</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="branch">Select Branch:</label>
            <select id="branch" name="branch" required>
                <option value="">Select Branch</option>
                <option value="1">Computer Science</option>
                <option value="2">Electronics</option>
                <option value="3">Mechanical</option>
                <option value="4">Civil</option>
            </select>

            <label for="subject">Select Subject:</label>
            <select id="subject" name="subject" required>
                <option value="">Select Subject</option>
                <option value="1">Data Structures</option>
                <option value="2">Digital Electronics</option>
                <option value="3">Thermodynamics</option>
                <option value="4">Structural Analysis</option>
            </select>

            <label for="file">Select File:</label>
            <input type="file" id="file" name="file" required>

            <button type="submit">Upload</button>
        </form>

        <!-- Display error or success message dynamically -->
        <?php echo $errorMessage; ?>
    </div>
</body>
</html>