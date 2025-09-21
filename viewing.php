<?php
    include "db.php";
    session_start();

    // Check if ID is passed in the URL
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $_SESSION['error'] = "Invalid request.";
        header("Location: summary_data.php");
        exit();
    }

    $id = intval($_GET['id']); // Convert ID to an integer for security
    $sql = "SELECT * FROM tbl_personal WHERE id = $id";
    $result = $conn->query($sql);

    // Check if record exists
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Record not found.";
        header("Location: summary_data.php");
        exit();
    }

    $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    
    <style>
    /* Base Styles */
    body {
        background-color:rgb(255, 255, 255);
        font-family: 'Roboto', sans-serif; /* Modern font */
        line-height: 1.6;
        color: #333;
    }

    .container {
        margin: 30px auto; /* Increased top/bottom margin */
        padding: 30px; /* Increased padding */
        background-color: #F5F5DC;
        border-radius: 10px; /* Slightly more rounded corners */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Stronger shadow */
        max-width:900px; /* Slightly wider */
    }

    h1 {
        text-align: center;
            margin-bottom: 25px; /* Added margin */
            position: relative;
            font-size: 2rem; /* Increased font size */
            font-weight: 600;
            color: #333; /* Darker heading color */
    }

    h1::after {
        content: "";
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: -8px; /* Adjusted position */
            width: 80px; /* Shorter underline */
            height: 4px; /* Slightly thicker underline */
            background: linear-gradient(to right, #3498db, #2980b9);
            border-radius: 2px;
            opacity: 0.9; /* More opaque */
    }

    h3 {
        background:rgb(255, 255, 255);
        color:black;
        padding: 12px 20px; /* Adjusted padding */
        border-radius: 6px; /* Slightly more rounded corners */
        margin-bottom: 20px; /* Increased margin */
        font-size: 1.2rem; /* Slightly larger font size */
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 20px; /* Increased margin */
    }

    .form-label {
        font-weight: 600;
        display: block;
        margin-bottom: 10px; /* Increased margin */
        color: #444;
    }

    .form-value {
        display: block;
        padding: 12px 15px; /* Adjusted padding */
        border-radius: 6px; /* Slightly more rounded corners */
       
        font-weight: normal;
        color: #555;
        line-height: 1.4; /* Added line-height */
    }

    .sub-label {
        font-size: 0.9rem; /* Slightly larger font size */
        color: #777;
        display: block;
        margin-top: 8px; /* Increased margin */
    }

    .radio-group {
        display: flex;
        align-items: center;
        gap: 25px; /* Increased gap */
    }

    .radio-group label {
        margin: 0;
    }

    /* Button Styles */
    .btn {
        background-color: #27ae60;
        color: white;
        padding: 14px 25px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        margin-right: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
        background-color: #2ecc71;
        border-color: #27ae60;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3); /* Stronger hover shadow */
        transform: translateY(-3px); /* Slight lift on hover */
    }

    .btn:focus {
        outline: none;
        box-shadow: 0 0 6px rgba(0, 123, 255, 0.7); /* Stronger focus shadow */
    }

</style>

</head>
<body>
    <div class="container">
    <h1 style="color: black; text-align: center;">View Record</h1>

        <h3>Personal Information</h3>
        <div class="row">
            <div class="col-md-4 form-group">
                <span class="form-label">ID</span>
                <span class="form-value"><?= $row['id']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Last Name</span>
                <span class="form-value"><?= $row['last_name']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">First Name</span>
                <span class="form-value"><?= $row['first_name']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Middle Initial</span>
                <span class="form-value"><?= $row['middle_initial']; ?></span>
            </div>
                    <div class="col-md-4 form-group"> 
            <span class="form-label">Date of Birth</span>
            <span class="form-value"><?= $row['date_of_birth']; ?></span>
        </div>

        <div class="col-md-4 form-group">
            <span class="form-label">Age</span>
            <span class="form-value">
                <?php 
                    $dob = new DateTime($row['date_of_birth']);
                    $today = new DateTime();
                    $age = $today->diff($dob)->y;
                    echo $age . " years old";
                ?>
            </span>
        </div>

            <div class="col-md-4 form-group">
                <span class="form-label">Sex</span>
                <span class="form-value"><?= $row['sex']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Civil Status</span>
                <span class="form-value"><?= $row['civil_status']; ?></span>
            </div>
            
            <div class="col-md-4 form-group">
                <span class="form-label">Tax Identification Number</span>
                <span class="form-value"><?= $row['tax_identification_number']; ?></span>
            </div>

            <div class="col-md-4 form-group">
                <span class="form-label">Nationality</span>
                <span class="form-value"><?= $row['nationality']; ?></span>
            </div>
            
            <div class="col-md-4 form-group">
                <span class="form-label">Religion</span>
                <span class="form-value"><?= $row['religion']; ?></span>
            </div>
            
            
            <h3>Place of Birth</h3>
            <div class="col-md-4 form-group">
                <span class="form-label">RM/FLR/Unit No. & Bldg. Name</span>
                <span class="form-value"><?= $row['Bldg_Name']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">House/Lot & Blk. No</span>
                <span class="form-value"><?= $row['House_Lot_Bl_No']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Street Name</span>
                <span class="form-value"><?= $row['Street_name']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Subdivision</span>
                <span class="form-value"><?= $row['subdivision']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Barangay/District/Locality</span>
                <span class="form-value"><?= $row['city']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">City/Municipalities</span>
                <span class="form-value"><?= $row['barangay']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Province</span>
                <span class="form-value"><?= $row['province']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Zip Code</span>
                <span class="form-value"><?= $row['zip']; ?></span>
            </div>
        </div>

        <h3>Home Address</h3>
        <div class="row">
        <div class="col-md-4 form-group">
                <span class="form-label">RM/FLR/Unit No. & Bldg. Name</span>
                <span class="form-value"><?= $row['RM_FLR_Unit_No']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">House/Lot & Blk. No</span>
                <span class="form-value"><?= $row['house_no']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Street Name</span>
                <span class="form-value"><?= $row['house_street']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Subdivision</span>
                <span class="form-value"><?= $row['house_subdivision']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Barangay/District/Locality</span>
                <span class="form-value"><?= $row['house_barangay']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">City/Municipality</span>
                <span class="form-value"><?= $row['house_city']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Province</span>
                <span class="form-value"><?= $row['house_province']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Barangay</span>
                <span class="form-value"><?= $row['house_barangay']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Country</span>
                <span class="form-value"><?= $row['country']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Zip Code</span>
                <span class="form-value"><?= $row['house_zip_code']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Country</span>
                <span class="form-value"><?= $row['country']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Mobile/Cellphone Number</span>
                <span class="form-value"><?= $row['mobile_number']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">E-mail Address</span>
                <span class="form-value"><?= $row['email']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Telephone Number</span>
                <span class="form-value"><?= $row['telephone_number']; ?></span>
            </div>
            

        <h3>Father's Information</h3>
        <div class="row">
            <div class="col-md-4 form-group">
                <span class="form-label">Father's Last Name</span>
                <span class="form-value"><?= $row['Father_last_name']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Father's First Name</span>
                <span class="form-value"><?= $row['Father_first_name']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label"> Middle Initial</span>
                <span class="form-value"><?= $row['Father_middle_initial']; ?></span>
            </div>

        </div>

        <h3>Mother's Maiden Name</h3>
        <div class="row">
            <div class="col-md-4 form-group">
                <span class="form-label">Mother's Last Name</span>
                <span class="form-value"><?= $row['Mother_last_name']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Mother's First Name</span>
                <span class="form-value"><?= $row['Mother_first_name']; ?></span>
            </div>
            <div class="col-md-4 form-group">
                <span class="form-label">Middle Initial</span>
                <span class="form-value"><?= $row['Mother_middle_initial']; ?></span>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="summary_data.php" class="btn btn-secondary">Back</a>
        </div>

    </div>
</body>
</html>