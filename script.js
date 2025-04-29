function validate() {
    //fullname validation.
    let fname = document.getElementById('ufullname');
    let nameRegx = /[0-9~!@#$%^&*()_+=\[\]{};':"\\|,.<>\/?]/.test(fname.value);
    if (nameRegx) {
        alert("Invalid full-name format.");
        return false;
    }

    //email validation.
    let email = document.getElementById('uemail').value;
    let emailRegx = /^[^\s@]+@(gmail|yahoo|outlook|hotmail|icloud|protonmail)\.(com|net|org|co\.uk|in|edu)$/i;
    if (!emailRegx.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    //password validation.
    let password = document.getElementById('upassword').value;
    let confirmPassword = document.getElementById('ucpassword').value;

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    let passwordRegx = /^[A-Za-z0-9]{8,}$/;
    if (!passwordRegx.test(password)) {
        alert("Password must:\n• Be at least 8 characters\n• Contain only letters and numbers.");
        return false;
    }

    //age validation.
    let dobInput = document.getElementById('udob').value;
    if (!dobInput) {
        alert("Please select your date of birth.");
        return false;
    }

    let dob = new Date(dobInput);
    let today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    let monthDiff = today.getMonth() - dob.getMonth();

    //check if birthday occurred yet this year.
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    if (age < 18) {
        alert("You must be at least 18 years old.");
        return false;
    }

    //country validation.
    let country = document.getElementById('ucountry').value;
    if (!country) {
        alert("Please select your country.");
        return false;
    }

    //gender validation.
    let genderSelected = document.querySelector('input[name="ugender"]:checked');
    if (!genderSelected) {
        alert("Please select your gender.");
        return false;
    }

    //preferred color.
    let colorInput = document.getElementById('ucolor');
    let userPreferredColor = colorInput.value;

    return true;
}