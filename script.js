function validateCheckboxes() {
    const checked = document.querySelectorAll('.checkbox-list input[type="checkbox"]:checked').length;
    if (checked > 10) {
        showLimitModal();
        return false;
    }
    return true;
}

function showLimitModal() {
    document.getElementById('limit-modal').style.display = 'flex';
    document.getElementById('request-box').style.filter = 'blur(4px)';
    document.body.classList.add('modal-open');
}

function closeLimitModal() {
    document.getElementById('limit-modal').style.display = 'none';
    document.getElementById('request-box').style.filter = 'none';
    document.body.classList.remove('modal-open');
}

function closeRegSuccessModal() {
    document.getElementById('registration-done-modal').style.display = 'none';
    document.getElementById('confirmation-container').style.filter = 'none';
    document.body.classList.remove('modal-open');
    setTimeout(function () {
        window.location.href = 'index.php';
    }, 500);
}

function closeUserExistModal() {
    document.getElementById('user-exists-modal').style.display = 'none';
    document.getElementById('confirmation-container').style.filter = 'none';
    document.body.classList.remove('modal-open');
    setTimeout(function () {
        history.go(-2);
    }, 500);
}

function showLoginSuccess() {
    document.getElementById('login-success-modal').style.display = 'flex';
    document.getElementById('main-container').style.filter = 'blur(4px)';
    document.body.classList.add('modal-open');

}

function closeLoginSuccess() {
    document.getElementById('login-success-modal').style.display = 'none';
    document.getElementById('main-container').style.filter = 'none';
    document.body.classList.remove('modal-open');
    setTimeout(function () {
        window.location.replace("requestaqi.php");
    }, 500);
}

function showLoginFailed(loginError) {
    document.getElementById('login-failed-modal').style.display = 'flex';
    document.getElementById('main-container').style.filter = 'blur(4px)';
    document.body.classList.add('modal-open');
    document.getElementById('login-failed-msg').textContent = loginError;
}

function closeLoginFailed() {
    document.getElementById('login-failed-modal').style.display = 'none';
    document.getElementById('main-container').style.filter = 'none';
    document.body.classList.remove('modal-open');
    setTimeout(function () {
        history.go(-1);
    }, 500);
}

function validate() {
    document.querySelectorAll('.error-message').forEach(msg => msg.style.display = 'none');

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

    let country = document.getElementById('ucountry').value.trim();
    if (country === "") {
        document.getElementById('ucountry-error').textContent = "Please select your country.";
        document.getElementById('ucountry-error').style.display = 'block';
        return false;
    }

    let genderSelected = document.querySelector('input[name="ugender"]:checked');
    if (!genderSelected) {
        document.getElementById('ugender-error').textContent = "Please select your gender.";
        document.getElementById('ugender-error').style.display = 'block';
        return false;
    }

    return true;
}