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
