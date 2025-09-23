<?php
session_start();
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Initialize errors array
            $errors = [];

            // Function to validate phone number format
            function validatePhoneNumber(&$errors, $field) {
                // Check if the phone number matches the expected format
                if (!empty($_POST[$field]) && !preg_match("/^\+1 \(\d{3}\) \d{3}-\d{4}$/", $_POST[$field])) {
                    $errors[$field] = "Enter a valid phone number (e.g.,  09123456789 or +639123456789).";
                }
            }

            // Validate the required fields, civil status, name fields, and other inputs
            validateRequiredFields($errors, $required_fields, $countries);
            validateCivilStatus($errors);
            validateNameFields($errors, ['house_province','province','city','house_city','religion','civil_other','last_name', 'first_name', 'middle_initial', 'Father_last_name', 'Father_first_name', 'Father_middle_initial', 'Mother_last_name', 'Mother_first_name', 'Mother_middle_initial','nationality']);
            validateNumericFields($errors, [ 'tax_identification_number', 'house_zip_code', 'zip', 'mobile_number']);
            validatePhoneNumber($errors, 'telephone_number'); 
            validateDateOfBirth($errors);
            validateEmail($errors);
            validateSex($errors);
    
            if (empty($errors)) {
            // Sanitize and prepare data
            $last_name = $_POST['last_name'];
            $first_name = $_POST['first_name'];
            $middle_initial = $_POST['middle_initial'];
            $date_of_birth = $_POST['date_of_birth'];
            $sex = $_POST['sex'] ?? '';
            $civil_status = $_POST['civil_status'];
            $civil_other = $_POST['civil_other'];
            $tax = $_POST['tax_identification_number'];
            $nationality= $_POST['nationality'];
            $religion = $_POST['religion'];
            $bldg_name = $_POST['Bldg_Name'];
            $house_lot = $_POST['House_Lot_Bl_No'];
            $street_name = $_POST['Street_name'];
            $subdivision = $_POST['subdivision'];
            $barangay = $_POST['barangay'];
            $city = $_POST['city'];
            $province = $_POST['province'];
            $zip_code = $_POST['zip'];  
            $rm_flr = $_POST['RM_FLR_Unit_No'];
            $blk_no = $_POST['house_no'];
            $h_street_name = $_POST['house_street'];
            $h_subdivision = $_POST['house_subdivision'];
            $h_barangay = $_POST['house_barangay'];
            $h_city = $_POST['house_city'];
            $h_province = $_POST['house_province'];
            $h_country = $_POST['country'];
            $h_zip_code = $_POST['house_zip_code'];
            $mobile = $_POST['mobile_number'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone_number'];
            $f_last_name = $_POST['Father_last_name'];
            $f_first_name =$_POST['Father_first_name'];
            $f_middle_initial = $_POST['Father_middle_initial'];
            $m_last_name = $_POST['Mother_last_name'];
            $m_first_name = $_POST['Mother_first_name'];
            $m_middle_initial = $_POST['Mother_middle_initial']; 
        
                        // Insert into the database
                $sql = "INSERT INTO tbl_personal 
                (last_name, first_name, middle_initial, date_of_birth, sex, civil_status, civil_other, 
                tax_identification_number, nationality, religion, Bldg_Name, House_Lot_Bl_No, Street_name, 
                subdivision, barangay, city, province, zip, RM_FLR_Unit_No, house_no, house_street, 
                house_subdivision, house_barangay, house_city, house_province, country, house_zip_code, 
                mobile_number, email, telephone_number, Father_last_name, Father_first_name, 
                Father_middle_initial, Mother_last_name, Mother_first_name, Mother_middle_initial) 
                VALUES ('$last_name', '$first_name', '$middle_initial', '$date_of_birth', '$sex', '$civil_status', '$civil_other',
                '$tax', '$nationality', '$religion', '$bldg_name', '$house_lot', '$street_name', 
                '$subdivision', '$barangay', '$city', '$province', '$zip_code', '$rm_flr', '$blk_no', 
                '$h_street_name', '$h_subdivision', '$h_barangay', '$h_city', '$h_province', '$h_country', 
                '$h_zip_code', '$mobile', '$email', '$telephone', '$f_last_name', '$f_first_name', 
                '$f_middle_initial', '$m_last_name', '$m_first_name', '$m_middle_initial')";

                $result = $conn->query($sql);

                if ($result === TRUE) {
                    $_SESSION['message'] = "Record added successfully!";
                    $_SESSION['status'] = "success"; // Set a success status
                } else {
                    $_SESSION['message'] = "Error: " . $conn->error;
                    $_SESSION['status'] = "error"; // Set an error status
                }
            
                $conn->close();
            }
        
            }
        ?>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="..." crossorigin="anonymous">
    <link rel="stylesheet" href="form.css">
    <title>Personal Data Form</title>

    <script>

           window.onload = function() {
            <?php if (isset($_SESSION['message'])) { ?>
                let message = "<?php echo addslashes($_SESSION['message']); ?>";
                let status = "<?php echo $_SESSION['status']; ?>";

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
            unset($_SESSION['message']); // Clear session to prevent showing alert again
            unset($_SESSION['status']); 
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
    <form method="post" action="" >
    <h1 style="color: black; text-align: center;">Personal Data</h1>

    <div class="form-group">
  
    <label for="last_name">
    <i class="fas fa-user"></i> Last Name
    </label>
    <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name"
       value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">

    <!-- Display Error Message -->
    <?php if (isset($errors['last_name'])): ?>
        <span class="error"><?php echo $errors['last_name']; ?></span>
    <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="first_name" > <i class="fas fa-user"></i> First Name
        </label>
        <input type="text" name="first_name" id="first_name" placeholder="Enter First Name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
        <?php if (isset($errors['first_name'])): ?>
            <span class="error"><?php echo $errors['first_name']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="middle_initial"> <i class="fas fa-user"> </i>Middle Initial
        </label>
        <input type="text" name="middle_initial" id="middle_initial" placeholder="Enter Middle Initial" maxlength="1" value="<?php echo isset($_POST['middle_initial']) ? htmlspecialchars($_POST['middle_initial']) : ''; ?>">
        <?php if (isset($errors['middle_initial'])): ?>
            <span class="error"><?php echo $errors['middle_initial']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
    <label for="date_of_birth"><i class="fa-solid fa-calendar-days"></i>Date of Birth</label>
    <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo isset($_POST['date_of_birth']) ? htmlspecialchars($_POST['date_of_birth']) : ''; ?>" oninput="validateAge()">
    <?php if (isset($errors['date_of_birth'])): ?>
        <span class="error"><?php echo $errors['date_of_birth']; ?></span>
    <?php endif; ?>
    <span id="age_error" class="error"></span> <!-- Error message for JavaScript validation -->
   </div>


   <div class="form-group">
    <label>Sex</label>
    <div class="radio-group">
    <input type="radio" name="sex" id="sex_male" value="Male"
    <?= (isset($_POST['sex']) && $_POST['sex'] === "Male") ? "checked" : ""; ?>> Male
  <input type="radio" name="sex" id="sex_female" value="Female"
    <?= (isset($_POST['sex']) && $_POST['sex'] === "Female") ? "checked" : ""; ?>> Female

    </div>
    <?php if (isset($errors['sex'])): ?>
        <span class="error"><?php echo $errors['sex']; ?></span>
    <?php endif; ?>
 </div>

      <div class="form-group">
    <label>Civil Status</label>
    <select name="civil_status" id="civil_status">
        <option value="" <?php echo (isset($_POST['civil_status']) && $_POST['civil_status'] == "") ? "selected" : ""; ?>>Select Civil Status</option>
        <option value="Single" <?php echo (isset($_POST['civil_status']) && $_POST['civil_status'] == "Single") ? "selected" : ""; ?>>Single</option>
        <option value="Married" <?php echo (isset($_POST['civil_status']) && $_POST['civil_status'] == "Married") ? "selected" : ""; ?>>Married</option>
        <option value="Widowed" <?php echo (isset($_POST['civil_status']) && $_POST['civil_status'] == "Widowed") ? "selected" : ""; ?>>Widowed</option>
        <option value="Legally Separated" <?php echo (isset($_POST['civil_status']) && $_POST['civil_status'] == "Legally Separated") ? "selected" : ""; ?>>Legally Separated</option>
        <option value="Others" <?php echo (isset($_POST['civil_status']) && $_POST['civil_status'] == "Others") ? "selected" : ""; ?>>Others</option>
    </select>
    <?php if (isset($errors['civil_status'])): ?>
        <span class="error"><?php echo $errors['civil_status']; ?></span>
     <?php endif; ?>
  </div>

     <div id="civil_other_div" style="display: <?php echo isset($_POST['civil_status']) && $_POST['civil_status'] === 'Others' ? 'block' : 'none'; ?>;">
    <label for="civil_other">Please specify:</label>
    <input type="text" name="civil_other" id="civil_other" placeholder="Please specify" value="<?php echo isset($_POST['civil_other']) ? htmlspecialchars($_POST['civil_other']) : ''; ?>" />
    <?php if (isset($errors['civil_other'])): ?>
        <span class="error"><?php echo $errors['civil_other']; ?></span>
    <?php endif; ?>
  </div>

   <div class="form-group">
    <label>Tax Identification Number</label>
    <input type="text" name="tax_identification_number" id="tax_identification_number" placeholder="Enter Tax Identification Number" value="<?= htmlspecialchars($_POST['tax_identification_number'] ?? '') ?>">

    <?php if (isset($errors['tax_identification_number'])): ?>
        <span class="error"><?= $errors['tax_identification_number'] ?></span>
    <?php endif; ?>
  </div>

    <div class="form-group">
        <label>Nationality</label>
        <input type="text" name="nationality" id="nationality" placeholder="Enter Nationality" value="<?php echo isset($_POST['nationality']) ? htmlspecialchars($_POST['nationality']) : ''; ?>">
        <?php if (isset($errors['nationality'])): ?>
            <span class="error"><?php echo $errors['nationality']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Religion</label>
        <input type="text" name="religion" id="religion" placeholder="Enter Religion" value="<?php echo isset($_POST['religion']) ? htmlspecialchars($_POST['religion']) : ''; ?>">
        <?php if (isset($errors['religion'])): ?>
            <span class="error"><?php echo $errors['religion']; ?></span>
        <?php endif; ?>
    </div>

 <fieldset>
    <legend>Place of Birth </legend>
    
    <div class="form-group">
    <label>RM/FLR/Unit No. & Bldg. Name</label>
    <input type="text" name="Bldg_Name" id="Bldg_Name" placeholder="Enter RM/FLR/Unit No. & Bldg. Name" value="<?php echo isset($_POST['Bldg_Name']) ? htmlspecialchars($_POST['Bldg_Name']) : ''; ?>">
    <?php if (isset($errors['Bldg_Name'])): ?>
        <span class="error"><?php echo $errors['Bldg_Name']; ?></span>
    <?php endif; ?>
   </div>

   <div class="form-group">
    <label>House/Lot & Blk. No</label>
    <input type="text" name="House_Lot_Bl_No" id="House_Lot_Bl_No" placeholder="Enter House/Lot & Blk. No" value="<?php echo isset($_POST['House_Lot_Bl_No']) ? htmlspecialchars($_POST['House_Lot_Bl_No']) : ''; ?>">
    <?php if (isset($errors['House_Lot_Bl_No'])): ?>
        <span class="error"><?php echo $errors['House_Lot_Bl_No']; ?></span>
    <?php endif; ?>
   </div>

    <div class="form-group">
        <label>Street Name</label>
        <input type="text" name="Street_name" id="'Street_name"  placeholder="Enter Street Name" value="<?php echo isset($_POST['Street_name']) ? htmlspecialchars($_POST['Street_name']) : ''; ?>">
        <?php if (isset($errors['Street_name'])): ?>
            <span class="error"><?php echo $errors['Street_name']; ?></span>
        <?php endif; ?>
    </div> 

      <!-- Subdivision -->
      <div class="form-group">
        <label>Subdivision</label>
        <input type="text" name="subdivision" id="subdivision" placeholder="Enter Subdivision" value="<?php echo isset($_POST['subdivision']) ? htmlspecialchars($_POST['subdivision']) : ''; ?>">
        <?php if (isset($errors['subdivision'])): ?>
            <span class="error"><?php echo $errors['subdivision']; ?></span>
        <?php endif; ?>
    </div>

    <!-- Barangay/District/Locality -->
    <div class="form-group">
        <label >Barangay/District/Locality</label>
        <input type="text" name="barangay" id="barangay" placeholder="Enter Barangay/District/Locality" value="<?php echo isset($_POST['barangay']) ? htmlspecialchars($_POST['barangay']) : ''; ?>">
        <?php if (isset($errors['barangay'])): ?>
            <span class="error"><?php echo $errors['barangay']; ?></span>
        <?php endif; ?>
    </div>

    <!-- City/Municipality -->
    <div class="form-group">
        <label >City/Municipality</label>
        <input type="text" name="city" id="city" placeholder="Enter city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
        <?php if (isset($errors['city'])): ?>
            <span class="error"><?php echo $errors['city']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label >Province</label>
        <input type="text" name="province" id="province"   placeholder="Enter Province" value="<?php echo isset($_POST['province']) ? htmlspecialchars($_POST['province']) : ''; ?>">
        <?php if (isset($errors['province'])): ?>
            <span class="error"><?php echo $errors['province']; ?></span>
        <?php endif; ?>
    </div>

     <div class="form-group">
        <label >Zip Code</label>
        <input type="text" name="zip" id="zip"   placeholder="Enter Zip Code" value="<?php echo isset($_POST['zip']) ? htmlspecialchars($_POST['zip']) : ''; ?>">
        <?php if (isset($errors['zip'])): ?>
            <span class="error"><?php echo $errors['zip']; ?></span>
        <?php endif; ?>
    </div>
        </fieldset>

        <fieldset>
        <legend>Home Address</legend>
        <div class="form-group">
        <label>RM/FLR/Unit No. & Bldg. Name</label>
    <input type="text" name="RM_FLR_Unit_No" id="RM_FLR_Unit_No" placeholder="Enter RM FLR Unit No & Bldg Name" value="<?php echo $_POST['RM_FLR_Unit_No'] ?? ''; ?>">
    <?php if (isset($errors['RM_FLR_Unit_No'])): ?>
        <span class="error"><?php echo $errors['RM_FLR_Unit_No']; ?></span>
    <?php endif; ?>
      </div>

       <div class="form-group">
    <label>House/Lot & Blk. No</label>
    <input type="text" name="house_no" id="house_no" placeholder="Enter House/Lot & Blk. No" value="<?php echo $_POST['house_no'] ?? ''; ?>">
    <?php if (isset($errors['house_no'])): ?>
        <span class="error"><?php echo $errors['house_no']; ?></span>
    <?php endif; ?>
</div>

      <div class="form-group">
    <label>Street Name</label>
    <input type="text" name="house_street" id="house_street" placeholder="Enter Street Name" value="<?php echo $_POST['house_street'] ?? ''; ?>">
    <?php if (isset($errors['house_street'])): ?>
        <span class="error"><?php echo $errors['house_street']; ?></span>
    <?php endif; ?>
   </div>

     <div class="form-group">
    <label>Subdivision</label>
    <input type="text" name="house_subdivision" id="house_subdivision" placeholder="Enter Subdivision" value="<?php echo $_POST['house_subdivision'] ?? ''; ?>">
    <?php if (isset($errors['house_subdivision'])): ?>
        <span class="error"><?php echo $errors['house_subdivision']; ?></span>
    <?php endif; ?>
</div>

        <div class="form-group">
            <label>Barangay/District/Locality</label>
            <input type="text" name="house_barangay" id="'house_barangay" placeholder="Enter Barangay/District/Locality" value="<?php echo $_POST['house_barangay'] ?? ''; ?>">
            <?php if (isset($errors['house_barangay'])): ?>
                <span class="error"><?php echo $errors['house_barangay']; ?></span>
            <?php endif; ?>
        </div>

    <div class="form-group">
        <label>City/Municipality</label>
        <input type="text" name="house_city" id="house_city" placeholder="Enter City/Municipality" value="<?php echo $_POST['house_city'] ?? ''; ?>">
        <?php if (isset($errors['house_city'])): ?>
            <span class="error"><?php echo $errors['house_city']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Province</label>
        <input type="text" name="house_province" id="house_province" placeholder="Enter Province" value="<?php echo $_POST['house_province'] ?? ''; ?>">
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
                <?php echo isset($_POST['country']) && $_POST['country'] == $country ? 'selected' : ''; ?>>
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
        <input type="text" name="house_zip_code" id="house_zip_code" placeholder="Enter Zip Code" value="<?php echo $_POST['house_zip_code'] ?? ''; ?>">
        <?php if (isset($errors['house_zip_code'])): ?>
            <span class="error"><?php echo $errors['house_zip_code']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Mobile / Cellphone Number</label>
        <input type="text" name="mobile_number" id="mobile_number"  placeholder="Enter Mobile Number" value="<?php echo isset($_POST['mobile_number']) ? htmlspecialchars($_POST['mobile_number']) : ''; ?>">
        <?php if (isset($errors['mobile_number'])): ?>
            <span class="error"><?php echo $errors['mobile_number']; ?></span>
        <?php endif; ?>
    </div> 
   
     <!-- Email Address -->
    <div class="form-group">
        <label >E-mail Address</label>
        <input type="text" name="email" id="email" placeholder="example@domain.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        <?php if (isset($errors['email'])): ?>
            <span class="error"><?php echo $errors['email']; ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
    <label >Telephone Number</label>
    <input type="text" name="telephone_number" id="telephone_number" placeholder="Enter Telephone Number"
           value="<?= htmlspecialchars($_POST['telephone_number'] ?? '') ?>">

    <?php if (isset($errors['telephone_number'])): ?>
        <span class="error"><?= $errors['telephone_number'] ?></span>
    <?php endif; ?>
    </div>
    </fieldset>

    <fieldset>
    <!-- Father's Last Name -->
    <legend>Father's Name</legend>
    <div class="form-group">
        <label for="Father_last_name"> <i class="fas fa-user"></i>Last Name:</label>
        <input type="text" name="Father_last_name" id="Father_last_name" placeholder="Enter Father's Last Name" 
            value="<?php echo isset($_POST['Father_last_name']) ? htmlspecialchars($_POST['Father_last_name']) : ''; ?>">
        <?php if (isset($errors['Father_last_name'])): ?>
            <span class="error"><?php echo $errors['Father_last_name']; ?></span>
        <?php endif; ?>
    </div>

    <!-- Father's First Name -->
    <div class="form-group">
        <label for="Father_first_name"> <i class="fas fa-user"></i>First Name</label>
        <input type="text" name="Father_first_name" id="Father_first_name" placeholder="Enter Father's First Name" 
            value="<?php echo isset($_POST['Father_first_name']) ? htmlspecialchars($_POST['Father_first_name']) : ''; ?>">
        <?php if (isset($errors['Father_first_name'])): ?>
            <span class="error"><?php echo $errors['Father_first_name']; ?></span>
        <?php endif; ?>
    </div>

    <!-- Father's Middle Initial -->
    <div class="form-group">
        <label for="Father_middle_initial"><i class="fas fa-user"></i>
        Middle Initial</label>
        <input type="text" name="Father_middle_initial" id="Father_middle_initial" placeholder="Enter  Father Middle Initial" maxlength="1" 
        value="<?php echo isset($_POST['Father_middle_initial']) ? htmlspecialchars($_POST['Father_middle_initial']) : ''; ?>">
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
           value="<?php echo isset($_POST['Mother_last_name']) ? htmlspecialchars($_POST['Mother_last_name']) : ''; ?>">
      <!-- Display Error Message -->
    <?php if (isset($errors['Mother_last_name'])): ?>
        <span class="error"><?php echo $errors['Mother_last_name']; ?></span>
    <?php endif; ?>
    </div>

    <div class="form-group">
    <label for="Mother_first_name"> <i class="fas fa-user"></i>First Name</label>
    <input type="text" name="Mother_first_name" id="Mother_first_name" placeholder="Enter  Mother First Name" 
           value="<?php echo isset($_POST['Mother_first_name']) ? htmlspecialchars($_POST['Mother_first_name']) : ''; ?>">
     <!-- Display Error Message -->
    <?php if (isset($errors['Mother_first_name'])): ?>
        <span class="error"><?php echo $errors['Mother_first_name']; ?></span>
    <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="Mother_middle_initial"> <i class="fas fa-user"></i>Middle Initial </label>
        <input type="text" name="Mother_middle_initial" id="Mother_middle_initial" placeholder="Enter  Mother Middle Initial" maxlength="1" 
        value="<?php echo isset($_POST['Mother_middle_initial']) ? htmlspecialchars($_POST['Mother_middle_initial']) : ''; ?>">
        <?php if (isset($errors['Mother_middle_initial'])): ?>
            <span class="error"><?php echo $errors['Mother_middle_initial']; ?></span>
        <?php endif; ?>
    </div>
     </fieldset>

     <div class="button-container">
     <button type="submit" name="submit" class="submit">Submit</button>
        <a href="summary_data.php" class="cancel-button">Cancel</a>
        
    </div>
    </form>
    </div>
    </body>
    </html>
