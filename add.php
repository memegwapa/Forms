<?php
include 'db.php'; // Include the database connection

// You can now directly use $conn here because db.connector.php defines it.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (Your validation code) ...

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO tbl_personal (/* ... your columns ... */) VALUES (/* ... your placeholders ... */)");

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error); // Basic error handling
        }

        // ... (Your bind_param and execute code - same as before) ...

        if ($stmt->execute()) {
            // ... (Success handling) ...
        } else {
            // ... (Error handling) ...
        }

        $stmt->close();
    } else {
        // ... (Validation error handling) ...
    }
}
?>

<form action="add.php" method="post">
    <button type="submit">Add</button>
</form>