<?php
session_start();
include "db.php"; // Ensure database connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input

    // Prepare a DELETE statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM tbl_personal WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['delete_message'] = "Record deleted successfully!";
        $_SESSION['delete_status'] = "success";
    } else {
        $_SESSION['delete_message'] = "Error deleting record: " . $conn->error;
        $_SESSION['delete_status'] = "error";
    }
    $stmt->close();
    $conn->close();

    // Redirect back to summary_data.php
    header("Location: summary_data.php");
    exit();
}
?>
