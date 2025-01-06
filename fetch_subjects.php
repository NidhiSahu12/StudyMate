<?php
include 'db.php';

if (isset($_GET['branch_id'])) {
    $branchId = $_GET['branch_id'];
    $result = $conn->query("SELECT * FROM subjects WHERE branch_id = '$branchId'");

    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }

    echo json_encode($subjects);
}
?>