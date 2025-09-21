    <?php
        session_start(); // Start session at the beginning
        include "db.php";
        $required_fields = [
            'last_name', 'first_name', 'middle_initial', 'nationality', 'mobile_number',
            'Street_name', 'Bldg_Name', 'House_Lot_Bl_No', 'RM_FLR_Unit_No',
            'house_no', 'house_street', 'house_subdivision', 'house_barangay', 'house_city',
            'house_province', 'house_zip_code', 'country'
        ];

        $countries = [
            "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", 
            "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", 
            "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", 
            "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo (Congo-Brazzaville)", "Costa Rica", 
            "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", 
            "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", 
            "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", 
            "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", 
            "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", 
            "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", 
            "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", 
            "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar (Burma)", "Namibia", "Nauru", "Nepal", 
            "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan", 
            "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", 
            "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", 
            "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", 
            "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Taiwan", 
            "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", 
            "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", 
            "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
        ];
        
        // Initialize variables with default values (more efficient and readable)
        $id = $last_name = $first_name = $middle_initial = "";
        $date_of_birth = $sex = $civil_status = $civil_other = ""; 
        $tax = $nationality = $religion = $bldg_name = $house_lot = $street_name = ""; 
        $subdivision = $barangay = $city = $province = $zip_code = $rm_flr = $blk_no = ""; 
        $h_street_name = $h_subdivision = $h_barangay = $h_city = $h_province = $h_country = ""; 
        $h_zip_code = $mobile = $email = $telephone = ""; 
        $f_last_name = $f_first_name = $f_middle_initial = ""; 
        $m_last_name = $m_first_name = $m_middle_initial = ""; 

        function isNotEmptyOrSpaces($value) {
            return trim($value) !== '';
        }

        function validateCountry($country, $countries) {
            if (!in_array($country, $countries)) {
                return "Please select a valid country.";
            }
            return null; // No error
        }

        function validateRequiredFields(&$errors, $fields, $countries) { // $countries as argument, $errors by reference
            foreach ($fields as $field) {
                if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                    $errors[$field] = ucfirst(str_replace("_", " ", $field)) . " is required.";
                }
            }

            // Validate country selection
            if (!empty($_POST['country'])) {
                $countryError = validateCountry($_POST['country'], $countries); // Use $countries argument
                if ($countryError) {
                    $errors['country'] = $countryError;
                } else {
                    $_SESSION['country'] = $_POST['country']; // Assuming this is intentional
                }
            } else {
                $errors['country'] = "Country is required.";
            }
            return $errors; // Not strictly necessary, but good practice
        }

        function validateCivilStatus(&$errors) {
            if (empty($_POST['civil_status'])) {
                $errors['civil_status'] = "Civil Status is required.";
            } elseif ($_POST['civil_status'] === 'Others' && empty(trim($_POST['civil_other']))) { // Corrected to civil_other
                $errors['civil_other'] = "The 'Others' field cannot be empty or just spaces."; // Corrected to civil_other
            } else {
                $_SESSION['civil_status'] = $_POST['civil_status'];
                if ($_POST['civil_status'] === 'Others') {
                    $_SESSION['civil_other'] = $_POST['civil_other']; // Corrected to civil_other
                }
            }
        }

        function validateNameFields(&$errors, $fields) {
            foreach ($fields as $field) {
                if (!empty($_POST[$field]) && preg_match("/\d/", $_POST[$field])) {
                    $errors[$field] = ucfirst(str_replace("_", " ", $field)) . " must not contain numbers.";
                }
            }
        }

        function validateNumericFields(&$errors, $fields) {
            foreach ($fields as $field) {
                if (!empty($_POST[$field]) && !preg_match("/^\d+$/", $_POST[$field])) {
                    $errors[$field] = ucfirst(str_replace("_", " ", $field)) . " must contain numbers only.";
                }
            }
        }

        function validateDateOfBirth(&$errors) {
            if (empty($_POST['date_of_birth'])) {
                $errors['date_of_birth'] = "Date of Birth is required.";
            } else {
                $dob = date("Y-m-d", strtotime($_POST['date_of_birth']));
                $birthDate = new DateTime($dob);
                $today = new DateTime();
                $age = $today->diff($birthDate)->y;

                if ($age < 18) {
                    $errors['date_of_birth'] = "You must be at least 18 years old.";
                } else {
                    $_SESSION['date_of_birth'] = $dob;
                    $_SESSION['age'] = $age;
                }
            }
        }

        function validateEmail(&$errors) {
            if (!empty($_POST['email']) && (!strpos($_POST['email'], '@') || !strpos($_POST['email'], '.'))) {
                $errors['email'] = "Please enter a valid email address. Example: example@domain.com";
            }
        }

        function validateSex(&$errors) {
            if (!isset($_POST['sex']) || (isset($_POST['sex']) && $_POST['sex'] !== 'Male' && $_POST['sex'] !== 'Female')) {
                $errors['sex'] = "Sex is required.";
            } else {
                $_SESSION['sex'] = $_POST['sex'];
            }
        }

        function validatePhoneNumber(&$errors, $field) {
            if (!empty($_POST[$field])) { // Only validate if a number is provided
                $telephone = preg_replace("/[^0-9+]/", "", $_POST[$field]);
                if (!preg_match("/^[0-9+]*$/", $telephone) || strlen($telephone) < 2) {
                    $errors[$field] =  "Enter a valid phone number (e.g.,  09123456789 or +639123456789).";
                }
            }
        }
        
        //Retrieve Data (if ID is provided)
        if (isset($_GET['id'])) {
        
            $user_id = $_GET['id'];
            
            $sql = "SELECT * FROM tbl_personal WHERE id = '$user_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $id = $row['id'];
                    $last_name = $row['last_name'];
                    $first_name = $row['first_name'];
                    $middle_initial = $row['middle_initial'];
                    $date_of_birth = $row['date_of_birth'];
                    $sex = $row['sex'];
                    $civil_status = $row['civil_status'];
                    $civil_other = $row['civil_other'];
                    $tax = $row['tax_identification_number'];
                    $nationality = $row['nationality'];
                    $religion = $row['religion'];
                    $bldg_name = $row['Bldg_Name'];
                    $house_lot = $row['House_Lot_Bl_No'];
                    $street_name = $row['Street_name'];
                    $subdivision = $row['subdivision'];
                    $barangay = $row['barangay'];
                    $city = $row['city'];
                    $province = $row['province'];
                    $zip_code = $row['zip'];
                    $rm_flr = $row['RM_FLR_Unit_No'];
                    $blk_no = $row['house_no'];
                    $h_street_name = $row['house_street'];
                    $h_subdivision = $row['house_subdivision'];
                    $h_barangay = $row['house_barangay'];
                    $h_city = $row['house_city'];
                    $h_province = $row['house_province'];
                    $h_country = $row['country'];
                    $h_zip_code = $row['house_zip_code'];
                    $mobile = $row['mobile_number'];
                    $email = $row['email'];
                    $telephone = $row['telephone_number'];
                    $f_last_name = $row['Father_last_name'];
                    $f_first_name = $row['Father_first_name'];
                    $f_middle_initial = $row['Father_middle_initial'];
                    $m_last_name = $row['Mother_last_name'];
                    $m_first_name = $row['Mother_first_name'];
                    $m_middle_initial = $row['Mother_middle_initial'];
                } else {
                echo "No record found!";
                exit();
            }
        }
            //  Handle Update Request
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
     // Validate the required fields, civil status, name fields, and other inputs
     validateRequiredFields($errors, $required_fields, $countries);
     validateCivilStatus($errors);
     validateNameFields($errors, ['province','house_province','city','house_city','civil_other','last_name', 'first_name', 'middle_initial', 'Father_last_name', 'Father_first_name', 'Father_middle_initial', 'Mother_last_name', 'Mother_first_name', 'Mother_middle_initial','nationality']);
     validateNumericFields($errors, ['tax_identification_number', 'house_zip_code', 'zip', 'mobile_number']);
     validatePhoneNumber($errors, 'telephone_number'); 
     validateDateOfBirth($errors);
     validateEmail($errors);
     validateSex($errors);

            $id = $_POST['id'];
            $last_name = trim($_POST['last_name']);
            $first_name = trim($_POST['first_name']);
            $middle_initial = trim($_POST['middle_initial']);
            $date_of_birth = trim($_POST['date_of_birth']);
            $sex = trim($_POST['sex']);
            $civil_status = trim($_POST['civil_status']);
            $civil_other = trim($_POST['civil_other']);
            $tax = trim($_POST['tax_identification_number']);
            $nationality= trim($_POST['nationality']);
            $religion = trim($_POST['religion']);
            $bldg_name = trim($_POST['Bldg_Name']);
            $house_lot = trim($_POST['House_Lot_Bl_No']);
            $street_name = trim($_POST['Street_name']);
            $subdivision = trim($_POST['subdivision']);
            $barangay = trim($_POST['barangay']);
            $city = trim($_POST['city']);
            $province = trim($_POST['province']);
            $zip_code = trim($_POST['zip']);  
            $rm_flr = trim($_POST['RM_FLR_Unit_No']);
            $blk_no = trim($_POST['house_no']);
            $h_street_name = trim($_POST['house_street']);
            $h_subdivision = trim($_POST['house_subdivision']);
            $h_barangay = trim($_POST['house_barangay']);
            $h_city = trim($_POST['house_city']);
            $h_province = trim($_POST['house_province']);
            $h_country = trim($_POST['country']);
            $h_zip_code = trim($_POST['house_zip_code']);
            $mobile = trim($_POST['mobile_number']);
            $email = trim($_POST['email']);
            $telephone = trim($_POST['telephone_number']);
            $f_last_name = trim($_POST['Father_last_name']);
            $f_first_name = trim($_POST['Father_first_name']);
            $f_middle_initial = trim($_POST['Father_middle_initial']);
            $m_last_name = trim($_POST['Mother_last_name']);
            $m_first_name = trim($_POST['Mother_first_name']);
            $m_middle_initial = trim($_POST['Mother_middle_initial']); 
    
    

     if (empty($errors)) {
        $sql = "UPDATE tbl_personal SET 
                last_name = '$last_name',
                first_name = '$first_name',
                middle_initial = '$middle_initial',
                date_of_birth = '$date_of_birth',
                sex = '$sex',
                civil_status = '$civil_status',
                civil_other = '$civil_other',
                tax_identification_number = '$tax',
                nationality = '$nationality',
                religion = '$religion',
                Bldg_Name = '$bldg_name',
                House_Lot_Bl_No = '$house_lot',
                Street_name = '$street_name',
                subdivision = '$subdivision',
                barangay = '$barangay',
                city = '$city',
                province = '$province',
                zip = '$zip_code',
                RM_FLR_Unit_No = '$rm_flr',
                house_no = '$blk_no',
                house_street = '$h_street_name',
                house_subdivision = '$h_subdivision',
                house_barangay = '$h_barangay',
                house_city = '$h_city',
                house_province = '$h_province',
                country = '$h_country',
                house_zip_code = '$h_zip_code',
                mobile_number = '$mobile',
                email = '$email',
                telephone_number = '$telephone',
                Father_last_name = '$f_last_name',
                Father_first_name = '$f_first_name',
                Father_middle_initial = '$f_middle_initial',
                Mother_last_name = '$m_last_name',
                Mother_first_name = '$m_first_name',
                Mother_middle_initial = '$m_middle_initial'
                WHERE id = '$id'";
            
            //  Ensure `$stmt` is created successfully
            $stmt = $conn->prepare($sql);
            if (!$stmt) {  //  Check for errors before using `$stmt`
                die("Error preparing SQL: " . $conn->error);
            }
            
            if ($stmt->execute()) {
                $_SESSION['update_message'] = "Record updated successfully!";
                $_SESSION['update_status'] = "success"; // Differentiate success from errors
            } else {
                $_SESSION['update_message'] = "Error updating record: " . $conn->error;
                $_SESSION['update_status'] = "error";
            }
            
            $stmt->close();
        }
        }

?>

<!DOCTYPE html>
<html>
<head> 
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="..." crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
   
    <script>

        window.onload = function() {
            <?php if (isset($_SESSION['update_message'])) { ?>
                let message = "<?php echo addslashes($_SESSION['update_message']); ?>";
                let status = "<?php echo $_SESSION['update_status']; ?>";

                let alertBox = document.createElement('div');
                alertBox.innerHTML = `
                    <div class='custom-alert'>
                        <div class='custom-alert-content'>
                            <i class='fas fa-${status === "success" ? "check-circle" : "times-circle"} alert-icon ${status}'>
                            </i>
                            <p>${message}</p>
                            <button id='okButton'>OK</button>
                        </div>
                    </div>
                `;
                      // Blur background
                document.querySelector('.container').style.filter = 'blur(5px)';

                document.body.appendChild(alertBox);

                // When "OK" is clicked, redirect to summary_data.php
                document.getElementById('okButton').onclick = function() {
                    window.location.href = 'summary_data.php';
                };
            <?php 
            unset($_SESSION['update_message']); // Clear session to prevent showing alert again
            unset($_SESSION['update_status']); 
            } ?>
        };

            document.addEventListener("DOMContentLoaded", function() {
        var civilStatusSelect = document.getElementById("civil_status");
        var othersField = document.getElementById("civil_other_div");

        // Function to toggle the "Others" field
        function toggleOthersField() {
            if (civilStatusSelect.value === "Others") {
                othersField.style.display = "block";  // Show "Others" field
            } else {
                othersField.style.display = "none";   // Hide "Others" field
            }
        }

        // Event listener for change event
        civilStatusSelect.addEventListener("change", toggleOthersField);

        // Initial check when page loads
        toggleOthersField();
    });


    function validateAge() {
        let dobInput = document.getElementById('date_of_birth').value;
        let ageError = document.getElementById('age_error');
        
        // Ensure ageError element exists in the DOM
        if (!ageError) {
            console.error("Element with id 'age_error' not found.");
            return;
        }

        if (dobInput) {
            let birthDate = new Date(dobInput);
            let today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            let monthDiff = today.getMonth() - birthDate.getMonth();
            
            // Adjust age calculation if the birth month hasn't occurred yet this year
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            // Display validation message if age is under 18 
            if (age < 18) {
                ageError.textContent = "Must not accept age below 18 years old.";
            } else {
                ageError.textContent = ""; // Clear the message if age is 18 or above
            }
        } else {
            ageError.textContent = ""; // Clear the message if no date is selected
        }
    }

</script>
</head>
<body>

<div class="container">
    <form method="post" action="">
    <h1 style="color: black; text-align: center;">Update Personal Data</h1>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">  

        <div class="form-group">
        <label for="last_name">
        <i class="fas fa-user"></i> Last Name
        </label>
            <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
            <?php if (isset($errors['last_name'])): ?>
                <span class="error"><?php echo $errors['last_name']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="first_name"><i class="fas fa-user"></i> 
                First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
            <?php if (isset($errors['first_name'])): ?>
                <span class="error"><?php echo $errors['first_name']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="middle_initial">
            <i class="fas fa-user"></i> Middle Initial</label>
            <input type="text" name="middle_initial" id="middle_initial" maxlength="1" value="<?php echo htmlspecialchars($middle_initial); ?>">
            <?php if (isset($errors['middle_initial'])): ?>
                <span class="error"><?php echo $errors['middle_initial']; ?></span>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
    <label for="date_of_birth"><i class="fa-solid fa-calendar-days"></i> Date of Birth</label>
    <input type="date" name="date_of_birth" id="date_of_birth" 
        value="<?php echo htmlspecialchars($date_of_birth); ?>" 
        oninput="validateAge()">
    
    <?php if (isset($errors['date_of_birth'])): ?>
        <span class="error"><?php echo $errors['date_of_birth']; ?></span>
    <?php endif; ?>

        <span id="age_error" class="error"></span> <!-- Error message for JavaScript validation -->
    </div>

    <div class="form-group">
        <label>Sex</label>
        <div class="radio-group">
            <label for="sex_male">
                <input type="radio" name="sex" id="sex_male" value="Male" <?= $sex === "Male" ? "checked" : ""; ?>> Male
            </label>
            <label for="sex_female">
                <input type="radio" name="sex" id="sex_female" value="Female" <?= $sex === "Female" ? "checked" : ""; ?>> Female
            </label>
        </div>
        <?php if (!empty($errors['sex'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['sex']); ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Civil Status</label>
        <select name="civil_status" id="civil_status">
            <option value="" <?= empty($civil_status) ? "selected" : ""; ?>>Select Civil Status</option>
            <option value="Single" <?= $civil_status === "Single" ? "selected" : ""; ?>>Single</option>
            <option value="Married" <?= $civil_status === "Married" ? "selected" : ""; ?>>Married</option>
            <option value="Widowed" <?= $civil_status === "Widowed" ? "selected" : ""; ?>>Widowed</option>
            <option value="Legally Separated" <?= $civil_status === "Legally Separated" ? "selected" : ""; ?>>Legally Separated</option>
            <option value="Others" <?= $civil_status === "Others" ? "selected" : ""; ?>>Others</option>
        </select>
        <?php if (!empty($errors['civil_status'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['civil_status']); ?></span>
        <?php endif; ?>
    </div>

    <div id="civil_other_div" style="display: <?php echo (isset($civil_status) && $civil_status === 'Others') ? 'block' : 'none'; ?>;">
        <label for="civil_other">Please specify:</label>
        <input type="text" name="civil_other" id="civil_other" placeholder="Please specify"    value="<?php echo isset($civil_other) ? htmlspecialchars($civil_other) : ''; ?>" />
        <?php if (!empty($errors['civil_other'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['civil_other']); ?></span>
        <?php endif; ?>
    </div>


    <div class="form-group">
        <label>Tax Identification Number</label>
        <input type="text" name="tax_identification_number" id="tax_identification_number" placeholder="Enter Tax Identification Number" value="<?php echo htmlspecialchars($tax); ?>">

        <?php if (isset($errors['tax_identification_number'])): ?>
            <span class="error"><?= $errors['tax_identification_number'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Nationality</label>
        <input type="text" name="nationality" id="nationality" placeholder="Enter Nationality" value="<?php echo htmlspecialchars($nationality); ?>">
        <?php if (isset($errors['nationality'])): ?>
            <span class="error"><?php echo $errors['nationality']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Religion</label>
        <input type="text" name="religion" id="religion" placeholder="Enter Religion"  value="<?php echo htmlspecialchars($religion); ?>">
        <?php if (isset($errors['religion'])): ?>
            <span class="error"><?php echo $errors['religion']; ?></span>
        <?php endif; ?>
    </div>
        </fieldset>

        <fieldset>
        <legend>Place of Birth </legend> 
            <div class="form-group">
            <label>RM/FLR/Unit No. & Bldg. Name</label>
            <input type="text" name="Bldg_Name" id="Bldg_Name" placeholder="Enter RM/FLR/Unit No. & Bldg. Name" value="<?php echo htmlspecialchars($religion); ?>">
            <?php if (isset($errors['Bldg_Name'])): ?>
                <span class="error"><?php echo $errors['Bldg_Name']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>House/Lot & Blk. No</label>
            <input type="text" name="House_Lot_Bl_No" id="House_Lot_Bl_No" placeholder="Enter House/Lot & Blk. No"  value="<?php echo htmlspecialchars($house_lot); ?>">
            <?php if (isset($errors['House_Lot_Bl_No'])): ?>
                <span class="error"><?php echo $errors['House_Lot_Bl_No']; ?></span>
            <?php endif; ?>
        </div>

            <div class="form-group">
                <label>Street Name</label>
                <input type="text" name="Street_name" id="'Street_name"  placeholder="Enter Street Name"  value="<?php echo htmlspecialchars($street_name); ?>">
                <?php if (isset($errors['Street_name'])): ?>
                    <span class="error"><?php echo $errors['Street_name']; ?></span>
                <?php endif; ?>
            </div> 

            <!-- Subdivision -->
            <div class="form-group">
                <label>Subdivision</label>
                <input type="text" name="subdivision" id="subdivision" placeholder="Enter Subdivision"  value="<?php echo htmlspecialchars($subdivision); ?>">
                <?php if (isset($errors['subdivision'])): ?>
                    <span class="error"><?php echo $errors['subdivision']; ?></span>
                <?php endif; ?>
            </div>

        <!-- Barangay/District/Locality -->
        <div class="form-group">
            <label >Barangay/District/Locality</label>
            <input type="text" name="barangay" id="barangay" placeholder="Enter Barangay/District/Locality"value="<?php echo htmlspecialchars($barangay); ?>">
            <?php if (isset($errors['barangay'])): ?>
                <span class="error"><?php echo $errors['barangay']; ?></span>
            <?php endif; ?>
        </div>

    <!-- City/Municipality -->
    <div class="form-group">
        <label >City/Municipality</label>
        <input type="text" name="city" id="city" placeholder="Enter city" value="<?php echo htmlspecialchars($city); ?>">
        <?php if (isset($errors['city'])): ?>
            <span class="error"><?php echo $errors['city']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label >Province</label>
        <input type="text" name="province" id="province"   placeholder="Enter Province" value="<?php echo htmlspecialchars($province); ?>">
        <?php if (isset($errors['province'])): ?>
            <span class="error"><?php echo $errors['province']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
            <label >Zip Code</label>
            <input type="text" name="zip" id="zip"   placeholder="Enter Zip Code" value="<?php echo htmlspecialchars($zip_code); ?>">
            <?php if (isset($errors['zip'])): ?>
                <span class="error"><?php echo $errors['zip']; ?></span>
            <?php endif; ?>
        </div>
        </fieldset>

        <fieldset>
        <legend>Home Address</legend>
      <div class="form-group">
     <label>RM/FLR/Unit No. & Bldg. Name</label>
    <input type="text" name="RM_FLR_Unit_No" id="RM_FLR_Unit_No" placeholder="Enter RM FLR Unit No & Bldg Name"value="<?php echo htmlspecialchars($rm_flr); ?>">
    <?php if (isset($errors['RM_FLR_Unit_No'])): ?>
        <span class="error"><?php echo $errors['RM_FLR_Unit_No']; ?></span>
    <?php endif; ?>
   </div>


    <div class="form-group">
        <label>House/Lot & Blk. No</label>
        <input type="text" name="house_no" id="house_no" placeholder="Enter House/Lot & Blk. No" value="<?php echo htmlspecialchars($house_lot); ?>">
        <?php if (isset($errors['house_no'])): ?>
            <span class="error"><?php echo $errors['house_no']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Street Name</label>
        <input type="text" name="house_street" id="house_street" placeholder="Enter Street Name" value="<?php echo htmlspecialchars($h_street_name); ?>">
        <?php if (isset($errors['house_street'])): ?>
            <span class="error"><?php echo $errors['house_street']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Subdivision</label>
        <input type="text" name="house_subdivision" id="house_subdivision" placeholder="Enter Subdivision" value="<?php echo htmlspecialchars($h_barangay); ?>">
        <?php if (isset($errors['house_subdivision'])): ?>
            <span class="error"><?php echo $errors['house_subdivision']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Barangay/District/Locality</label>
        <input type="text" name="house_barangay" id="'house_barangay" placeholder="Enter Barangay/District/Locality" value="<?php echo htmlspecialchars($h_barangay); ?>">
        <?php if (isset($errors['house_barangay'])): ?>
            <span class="error"><?php echo $errors['house_barangay']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>City/Municipality</label>
        <input type="text" name="house_city" id="house_city" placeholder="Enter City/Municipality" value="<?php echo htmlspecialchars($h_city); ?>">
        <?php if (isset($errors['house_city'])): ?>
            <span class="error"><?php echo $errors['house_city']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Province</label>
        <input type="text" name="house_province" id="house_province" placeholder="Enter Province" value="<?php echo htmlspecialchars($h_province); ?>">
        <?php if (isset($errors['house_province'])): ?>
            <span class="error"><?php echo $errors['house_province']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
    <label for="country"><i class="fa-solid fa-globe"></i>Country
    </label>
    <select name="country" id="country">
        <option value="">Select Country</option> <!-- Default option -->
        <?php foreach ($countries as $country): ?>
            <option value="<?php echo $country; ?>"
                <?php echo htmlspecialchars($country) == $country ? 'selected' : ''; ?>>
                <?php echo $country; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['country'])): ?>
        <span class="error"><?php echo $errors['country']; ?></span>
    <?php endif; ?>
</div>

    <div class="form-group">
        <label>Zip Code</label>
        <input type="text" name="house_zip_code" id="house_zip_code" placeholder="Enter Zip Code" value="<?php echo htmlspecialchars($h_zip_code); ?>">
        <?php if (isset($errors['house_zip_code'])): ?>
            <span class="error"><?php echo $errors['house_zip_code']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Mobile / Cellphone Number</label>
        <input type="text" name="mobile_number" id="mobile_number"  placeholder="Enter Mobile Number" value="<?php echo htmlspecialchars($mobile); ?>">
        <?php if (isset($errors['mobile_number'])): ?>
            <span class="error"><?php echo $errors['mobile_number']; ?></span>
        <?php endif; ?>
    </div> 
   
     <!-- Email Address -->
    <div class="form-group">
        <label >E-mail Address</label>
        <input type="text" name="email" id="email" placeholder="example@domain.com" value="<?php echo htmlspecialchars($email); ?>">
        <?php if (isset($errors['email'])): ?>
            <span class="error"><?php echo $errors['email']; ?></span>
        <?php endif; ?>
    </div>

        <div class="form-group">
        <label>Telephone Number</label>
     <input type="text" name="telephone_number" id="telephone_number" placeholder="+1 (XXX) XXX-XXXX"
           value="<?php echo htmlspecialchars($telephone); ?>">
     <?php if (isset($errors['telephone_number'])): ?>
        <span class="error"><?php echo $errors['telephone_number']; ?></span>
        <?php endif; ?>
        </div>
    </fieldset>
    
    <fieldset>
    <!-- Father's Last Name -->
    <legend>Father's Name</legend>
    <div class="form-group">
        <label for="Father_last_name"> <i class="fas fa-user"></i>Last Name:</label>
        <input type="text" name="Father_last_name" id="Father_last_name" placeholder="Enter Father's Last Name" 
        value="<?php echo htmlspecialchars($f_last_name); ?>">
        <?php if (isset($errors['Father_last_name'])): ?>
            <span class="error"><?php echo $errors['Father_last_name']; ?></span>
        <?php endif; ?>
    </div>

    <!-- Father's First Name -->
    <div class="form-group">
        <label for="Father_first_name"> <i class="fas fa-user"></i>First Name</label>
        <input type="text" name="Father_first_name" id="Father_first_name" placeholder="Enter Father's First Name" 
        value="<?php echo htmlspecialchars($f_first_name); ?>">
        <?php if (isset($errors['Father_first_name'])): ?>
            <span class="error"><?php echo $errors['Father_first_name']; ?></span>
        <?php endif; ?>
    </div>

    <!-- Father's Middle Initial -->
    <div class="form-group">
        <label for="Father_middle_initial"><i class="fas fa-user"></i>
        Middle Initial</label>
        <input type="text" name="Father_middle_initial" id="Father_middle_initial" placeholder="Enter  Father Middle Initial" maxlength="1" 
        value="<?php echo htmlspecialchars($f_middle_initial); ?>">
        <?php if (isset($errors['Father_middle_initial'])): ?>
            <span class="error"><?php echo $errors['Father_middle_initial']; ?></span>
        <?php endif; ?>
    </div>
     </fieldset>

     <fieldset>
     <legend>Mother's Maiden Name</legend>
       <div class="form-group">
    <label for="Mother_last_name"> 
        <i class="fas fa-user"></i>Last Name</label>
    <input type="text" name="Mother_last_name" id="Mother_last_name" placeholder="Enter  Mother Last Name" 
    value="<?php echo htmlspecialchars($m_last_name); ?>">
     <!-- Display Error Message -->
    <?php if (isset($errors['Mother_last_name'])): ?>
        <span class="error"><?php echo $errors['Mother_last_name']; ?></span>
    <?php endif; ?>
    </div>

    <div class="form-group">
    <label for="Mother_first_name"> <i class="fas fa-user"></i>First Name</label>
    <input type="text" name="Mother_first_name" id="Mother_first_name" placeholder="Enter  Mother First Name" 
    value="<?php echo htmlspecialchars($m_first_name); ?>">
    <!-- Display Error Message -->
    <?php if (isset($errors['Mother_first_name'])): ?>
        <span class="error"><?php echo $errors['Mother_first_name']; ?></span>
    <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="Mother_middle_initial"> <i class="fas fa-user"></i>Middle Initial </label>
        <input type="text" name="Mother_middle_initial" id="Mother_middle_initial" placeholder="Enter  Mother Middle Initial" maxlength="1" 
        value="<?php echo htmlspecialchars($m_middle_initial); ?>">
        <?php if (isset($errors['Mother_middle_initial'])): ?>
            <span class="error"><?php echo $errors['Mother_middle_initial']; ?></span>
        <?php endif; ?>
    </div>
     </fieldset>

     <div class="button-container">
     <button type="submit" name="update" class="update">Update</button>
        <a href="summary_data.php" class="cancel-button">Cancel</a>
    </div>

    </form>
</div>
</body>
</html>
