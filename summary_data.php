<?php
    include "db.php";
    $sql = "SELECT * FROM tbl_personal";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <script>

        window.onload = function() {
            <?php if (isset($_SESSION['delete_message'])) { ?>
                let message = "<?php echo addslashes($_SESSION['delete_message']); ?>";
                let status = "<?php echo $_SESSION['delete_status']; ?>";

                let container = document.querySelector('.container'); // Blur the content
                if (container) {
                    container.style.filter = 'blur(5px)';
                }

                let alertBox = document.createElement('div');
                alertBox.className = 'custom-alert';
                alertBox.innerHTML = `
                    <div class='custom-alert-content'>
                        <i class='fas fa-${status === "success" ? "check-circle" : "times-circle"} alert-icon ${status}'></i>
                        <p>${message}</p>
                    </div>
                `;

                document.body.appendChild(alertBox);

                // Auto-close the pop-up after 3 seconds
                setTimeout(function() {
                    alertBox.remove();
                    if (container) {
                        container.style.filter = 'none';
                    }
                }, 3000); // Closes after 3 seconds

            <?php 
            unset($_SESSION['delete_message']); // Clear session message
            unset($_SESSION['delete_status']);
            } ?>
        };

    </script>

    <style>

      :root {
        --primary-color: #007bff;
        --background-color:rgb(255, 255, 255);
        --border-color: #dee2e6;
        --light-gray: #F5F5DC;
        --hover-background: #f0f0f0; /* Correctly defined as a variable */
        --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        --padding-sm: 8px 16px;
        --padding-md: 12px 20px;
        --border-radius: 6px;
        --box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    body {
        font-family: var(--font-family);
        line-height: 1.6;
        
    }

    .sticky-header {
        position: sticky;
        background-color: white;
        padding: var(--padding-md);
       
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border-color);
        box-shadow: var(--box-shadow);
    }

    .sticky-header h1 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
    }

    .btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: var(--padding-sm);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
        text-decoration: none; 
    }

    .btn:hover {
        background-color: #0056b3;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .btn:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.7);
    }

    .btn:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
    }

    /* Improved Delete Button Styles */
    .btn-danger,
    .btn-delete { 

        background-color: #dc3545; 
        color: white; /* Ensure text is white */
        border: none;
        padding: var(--padding-sm); /* Use your padding variable */
        border-radius: var(--border-radius); /* Use your border radius variable */
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 2px rgba(220, 53, 69, 0.3); /* Slightly darker shadow */

    }

    .btn-danger:hover,
    .btn-delete:hover {

        background-color: #c82333; /* Darker red on hover */
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.5); /* Stronger hover shadow */
    }

    .btn-danger:focus,
    .btn-delete:focus {

        outline: none;
        box-shadow: 0 0 5px rgba(220, 53, 69, 0.7); /* Red focus shadow */
    }

    .btn-danger:disabled,
    .btn-delete:disabled {

        background-color: #cccccc;
        cursor: not-allowed;
    }
        .container {

            margin: 20px auto;
            padding: var(--padding-md);
            overflow-x: auto;
            white-space: nowrap;
        }

        .table {
           
            border-collapse: collapse;
            border: 1px solid var(--border-color);
            box-shadow: var(--box-shadow);
        }

        .table th,
        .table td {

            padding: 12px;
            text-align: center;
            border: 1px solid var(--border-color);
            line-height: 1.5;
        }

        .table th {
            background-color: var(--light-gray);
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        .table tbody tr:hover {
            background-color: var(--hover-background);
            transition: background-color 0.3s ease;
        }

        .sticky-action {
            position: sticky;
            right: 0;
            background-color: white;
            z-index: 1;
            border-left: 1px solid var(--border-color);
            text-align: center;
            white-space: nowrap;
        }

        .sticky-th.id,
        .sticky-th.last-name,
        .sticky-th.first-name {
            position: sticky;
            left: 0; /* Changed to left: 0 */
            background-color: white;
            z-index: 2; /* Increased z-index */
            border-right: 1px solid var(--border-color); /* Changed to border-right */
            text-align: center;
            white-space: nowrap;
            transition: background-color 0.3s ease; /* Added transition */
        }

        .sticky-th:hover,
        .sticky-th.last-name:hover,
        .sticky-th.first-name:hover {
            background-color: var(--hover-background); /* Corrected hover background */
        }

        .sticky-th.last-name {
            left: 30px;
        }

        .sticky-th.first-name {
            left: 130px;
            border-right: 1px solid var(--border-color);
        }
       
        /* Custom Alert Box */
        .custom-alert {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .custom-alert-content {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
            text-align: center;
            width: 350px; /* SAME SIZE AS UPDATE ALERT */
            position: relative;
        }

        /* Buttons */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px; /* Space between buttons */
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Delete Button */
        .delete-btn {
            background: red;
            color: white;
        }
        .delete-btn:hover {
            background: darkred;
        }

        /* Cancel Button */
        .cancel-btn {
            background: gray;
            color: white;
        }

        .cancel-btn:hover {
            background: darkgray;
        }

</style>

</head>
<body>
    <div class="sticky-header">
        <h1>Summary</h1>
        <a class="btn btn-primary" href="index.php" role="button">New data</a>
    </div>

    <div class="container">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr >
                        <th class="sticky-th id">ID</th>
                        <th class="sticky-th last-name">Last Name</th>
                        <th class="sticky-th first-name">First Name</th>
                        <th>Middle Initial</th>
                        <th>Date of Birth</th>
                        <th>Sex</th>
                        <th>Civil Status</th>
                        <th>Others</th>
                        <th>Tax Identification Number</th>
                        <th>Nationality</th>
                        <th>Religion</th>
                        <th>RM/FLR/Unit No. & Bldg. Name</th>
                        <th>House/Lot & Blk. No</th>
                        <th>Street Name</th>
                        <th>Subdivision</th>
                        <th>Barangay/District/Locality</th>
                        <th>City/Municipality</th>
                        <th>Province</th>
                        <th>Zip Code</th>
                        <th>House RM/FLR/Unit No. & Bldg. Name</th>
                        <th>House/Lot & Blk. No</th>
                        <th>House Street Name</th>
                        <th>House Subdivision</th>
                        <th>House Barangay/District/Locality</th>
                        <th>House City/Municipality</th>
                        <th>House Province</th>
                        <th>House Country</th>
                        <th>House Zip Code</th>
                        <th>Mobile / Cellphone Number</th>
                        <th>E-mail Address</th>
                        <th>Telephone Number</th>
                        <th>Father's Last Name</th>
                        <th>Father's First Name</th>
                        <th>Father's Middle Initial</th>
                        <th>Mother's Last Name</th>
                        <th>Mother's First Name</th>
                        <th>Mother's Middle Initial</th>
                        <th class="sticky-action">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                    ?>
                                <tr>
                                    <td class="sticky-th id"><?php echo $row['id']; ?></td>
                                    <td class="sticky-th last-name"><?php echo $row['last_name']; ?></td>
                                    <td class="sticky-th first-name"><?php echo $row['first_name']; ?></td>
                                    <td><?php echo $row['middle_initial']; ?></td>
                                    <td><?php echo $row['date_of_birth']; ?></td>
                                    <td><?php echo $row['sex']; ?></td>
                                    <td><?php echo $row['civil_status']; ?></td>
                                    <td><?php echo $row['civil_other']; ?></td>
                                    <td><?php echo $row['tax_identification_number']; ?></td>
                                    <td><?php echo $row['nationality']; ?></td>
                                    <td><?php echo $row['religion']; ?></td>
                                    <td><?php echo $row['Bldg_Name']; ?></td>
                                    <td><?php echo $row['House_Lot_Bl_No']; ?></td>
                                    <td><?php echo $row['Street_name']; ?></td>
                                    <td><?php echo $row['subdivision']; ?></td>
                                    <td><?php echo $row['barangay']; ?></td>
                                    <td><?php echo $row['city']; ?></td>
                                    <td><?php echo $row['province']; ?></td>
                                    <td><?php echo $row['zip']; ?></td>
                                    <td><?php echo $row['RM_FLR_Unit_No']; ?></td>
                                    <td><?php echo $row['house_no']; ?></td>
                                    <td><?php echo $row['house_street']; ?></td>
                                    <td><?php echo $row['house_subdivision']; ?></td>
                                    <td><?php echo $row['house_barangay']; ?></td>
                                    <td><?php echo $row['house_city']; ?></td>
                                    <td><?php echo $row['house_province']; ?></td>
                                    <td><?php echo $row['country']; ?></td>
                                    <td><?php echo $row['house_zip_code']; ?></td>
                                    <td><?php echo $row['mobile_number']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['telephone_number']; ?></td>
                                    <td><?php echo $row['Father_last_name']; ?></td>
                                    <td><?php echo $row['Father_first_name']; ?></td>
                                    <td><?php echo $row['Father_middle_initial']; ?></td>
                                    <td><?php echo $row['Mother_last_name']; ?></td>
                                    <td><?php echo $row['Mother_first_name']; ?></td>
                                    <td><?php echo $row['Mother_middle_initial']; ?></td>
                                    <td class='sticky-action'>
                                    <a class='btn btn-info btn-sm' href='viewing.php?id=<?php echo $row['id']; ?>'>View</a>
                                    <a class='btn btn-primary btn-sm' href='update.php?id=<?= $row['id']; ?>'>Edit</a> &nbsp;
                                    <a href="#" class="btn btn-danger btn-sm"
                        onclick="confirmDelete(event, '<?= htmlspecialchars($row['id'], ENT_QUOTES); ?>',
                                    '<?= htmlspecialchars($row['last_name'], ENT_QUOTES); ?>',
                                    '<?= htmlspecialchars($row['first_name'], ENT_QUOTES); ?>',
                                    '<?= htmlspecialchars($row['middle_initial'], ENT_QUOTES); ?>');">
                            Delete
                        </a>

        <script>

        function confirmDelete(event, id, last_name, first_name, middle) {
            event.preventDefault(); // Prevent direct navigation

            let overlay = document.createElement('div');
            overlay.className = 'custom-alert';
            overlay.innerHTML = `
                <div class='custom-alert-content'>
                    <p>Are you sure you want to delete <br> 
                    <b>${last_name} ${first_name} ${middle}</b>?</p>
                    <div class='button-container'>
                        <button id='cancelDelete' class='cancel-btn'>Cancel</button>
                        <button id='confirmDelete' class='delete-btn'>Yes, Delete</button>
                    </div>
                </div>
            `;

            document.body.appendChild(overlay);

            // Handle cancel
            document.getElementById('cancelDelete').onclick = function() {
                overlay.remove();
            };

            // Handle confirm delete
            document.getElementById('confirmDelete').onclick = function() {
                overlay.innerHTML = `
                    <div class='custom-alert-content'>
                        <p><b>${last_name} ${first_name} ${middle}</b> has been successfully deleted!</p>
                    </div>
                `;

                // Blur background
                document.querySelector('.container').style.filter = 'blur(5px)';

                // Auto-close after 3 seconds, then redirect
                setTimeout(function() {
                    window.location.href = `delete.php?id=${id}`;
                }, 3000);
            };
        }
        
        </script>

    </td>
            </tr>
    <?php
        }

    }
    ?>
                </tbody>
    </table>
        </div>
    </body>
    </html>
