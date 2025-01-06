<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branch_id = $_POST['branch'];
    $subject_id = $_POST['subject'];

    $sql = "SELECT * FROM files WHERE subject_id='$subject_id' AND status='approved'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>View Notes</h2>
        <form method="POST">
            <label for="branch">Select Branch:</label>
            <select id="branch" name="branch" required>
                <option value="1">Computer Science</option>
                <option value="2">Electronics</option>
                <option value="3">Mechanical</option>
                <option value="4">Civil</option>
            </select>

            <label for="subject">Select Subject:</label>
            <select id="subject" name="subject" required>
                <option value="1">Data Structures</option>
                <option value="2">Digital Electronics</option>
                <option value="3">Thermodynamics</option>
                <option value="4">Structural Analysis</option>
            </select>

            <button type="submit">View Notes</button>
        </form>

        <?php if (isset($result)) { ?>
            <h3>Approved Notes:</h3>
            <ul>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <li><a href="uploads/<?php echo $row['filename']; ?>" target="_blank"><?php echo $row['filename']; ?></a></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</body>
</html>