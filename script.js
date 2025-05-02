function validate() {
    // Hide all error messages initially
    document.querySelectorAll('.error-message').forEach(msg => msg.style.display = 'none');

    // Validate Full Name
    let fname = document.getElementById('ufullname');
    if (fname.value.trim() === "") {
        document.getElementById('ufullname-error').textContent = "Please enter your full name.";
        document.getElementById('ufullname-error').style.display = 'block';
        return false;
    } else {
        let nameRegx = /^[A-Za-z\s]+$/;
        if (!nameRegx.test(fname.value.trim())) {
            document.getElementById('ufullname-error').textContent = "Full name can only contain alphabets.";
            document.getElementById('ufullname-error').style.display = 'block';
            return false;
        }
    }

    // Validate Email
    let email = document.getElementById('uemail').value.trim();
    let emailRegx = /^[^\s@]+@(gmail|yahoo|outlook|hotmail|icloud|protonmail)\.(com|net|org|co\.uk|in|edu)$/i;
    if (email === "") {
        document.getElementById('uemail-error').textContent = "Please enter your email address.";
        document.getElementById('uemail-error').style.display = 'block';
        return false;
    } else if (!emailRegx.test(email)) {
        document.getElementById('uemail-error').textContent = "Please enter a valid email address.";
        document.getElementById('uemail-error').style.display = 'block';
        return false;
    }

    // Validate Password
    let password = document.getElementById('upassword').value.trim();
    let confirmPassword = document.getElementById('ucpassword').value.trim();
    if (password === "") {
        document.getElementById('upassword-error').textContent = "Please enter your password.";
        document.getElementById('upassword-error').style.display = 'block';
        return false;
    } else if (password.length < 8) {
        document.getElementById('upassword-error').textContent = "Password must be at least 8 characters long.";
        document.getElementById('upassword-error').style.display = 'block';
        return false;
    }

    if (confirmPassword === "") {
        document.getElementById('ucpassword-error').textContent = "Please confirm your password.";
        document.getElementById('ucpassword-error').style.display = 'block';
        return false;
    } else if (password !== confirmPassword) {
        document.getElementById('ucpassword-error').textContent = "Passwords do not match.";
        document.getElementById('ucpassword-error').style.display = 'block';
        return false;
    }

    // Validate Date of Birth
    let dobInput = document.getElementById('udob').value.trim();
    if (dobInput === "") {
        document.getElementById('udob-error').textContent = "Please select your date of birth.";
        document.getElementById('udob-error').style.display = 'block';
        return false;
    } else {
        let dob = new Date(dobInput);
        let today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        let monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        if (age < 18) {
            document.getElementById('udob-error').textContent = "You must be at least 18 years old.";
            document.getElementById('udob-error').style.display = 'block';
            return false;
        }
    }

    // Validate Country
    let country = document.getElementById('ucountry').value.trim();
    if (country === "") {
        document.getElementById('ucountry-error').textContent = "Please select your country.";
        document.getElementById('ucountry-error').style.display = 'block';
        return false;
    }

    // Validate Gender
    let genderSelected = document.querySelector('input[name="ugender"]:checked');
    if (!genderSelected) {
        document.getElementById('ugender-error').textContent = "Please select your gender.";
        document.getElementById('ugender-error').style.display = 'block';
        return false;
    }

    // If all validations pass
    return true;
}