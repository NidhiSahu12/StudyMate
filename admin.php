<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['email'] !== 'admin@example.com') {
    echo "Access denied. Admins only.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileId = $_POST['file_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $sql = "UPDATE files SET status='approved' WHERE id='$fileId'";
    } elseif ($action === 'reject') {
        $sql = "UPDATE files SET status='rejected' WHERE id='$fileId'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "File status updated.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h3>Pending Files:</h3>
<ul>
    <?php
    $result = $conn->query("SELECT files.*, subjects.name AS subject, branches.name AS branch, users.name AS uploader 
                            FROM files
                            JOIN subjects ON files.subject_id = subjects.id
                            JOIN branches ON subjects.branch_id = branches.id
                            JOIN users ON files.user_id = users.id
                            WHERE files.status = 'pending'");

    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['filename'] . " (Branch: " . $row['branch'] . ", Subject: " . $row['subject'] . ", Uploaded by: " . $row['uploader'] . ")";
        echo "<form method='POST' style='display:inline;'>
                <input type='hidden' name='file_id' value='" . $row['id'] . "'>
                <button type='submit' name='action' value='approve'>Approve</button>
                <button type='submit' name='action' value='reject'>Reject</button>
              </form></li>";
    }
    ?>
</ul>