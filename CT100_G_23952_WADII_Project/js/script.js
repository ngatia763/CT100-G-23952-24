// Function 1: Dynamic visibility control (onchange event)
function showWorkshop() {
    let category = document.getElementById('category').value;
    let workshopGroup = document.getElementById('workshop-group');
    let workshopCheckbox = document.getElementById('workshop');

    if (category === 'Workshop Participant') {
        workshopGroup.style.display = 'block';
    } else {
        workshopGroup.style.display = 'none';
        workshopCheckbox.checked = false;
    }
    calculateFee();
}

function showMeals() {
    let cateringCheck = document.getElementById('catering-check');
    let mealGroup = document.getElementById('meal-group');
    let mealsCheckbox = document.getElementById('meals');

    if (cateringCheck.checked) {
        mealGroup.style.display = 'block';
    } else {
        mealGroup.style.display = 'none';
        mealsCheckbox.checked = false;
    }
    calculateFee();
}

// Function 2: Automatic Fee Calculator (oninput / onchange events) + 3-Day Discount
function calculateFee() {
    let regFee = 1000;
    let days = parseInt(document.getElementById('days').value) || 0;
    let attendanceFee = days * 500;
    
    let workshopFee = document.getElementById('workshop').checked ? 750 : 0;
    let mealFee = document.getElementById('meals').checked ? (days * 300) : 0;

    let subtotal = regFee + attendanceFee + workshopFee + mealFee;
    let discountNotice = document.getElementById('discount-notice');
    let finalTotal = subtotal;

    // Requirement 0 Individualization rule: 10% discount when attendance is 3 days
    if (days === 3) {
        finalTotal = subtotal - (subtotal * 0.10);
        discountNotice.style.display = 'block';
    } else {
        discountNotice.style.display = 'none';
    }

    document.getElementById('total-display').innerText = "KSh " + finalTotal.toLocaleString();
    document.getElementById('total_amount').value = finalTotal;
}

// Function 3: Form Validation (onsubmit event)
function validateForm() {
    let fullname = document.getElementById('fullname').value.trim();
    let email = document.getElementById('email').value.trim();
    let phone = document.getElementById('phone').value.trim();
    let days = document.getElementById('days').value;
    let category = document.getElementById('category').value;
    let errorBox = document.getElementById('error-message');

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (fullname === "") {
        errorBox.innerText = "Error: Full name cannot be empty.";
        return false;
    }
    if (!emailPattern.test(email)) {
        errorBox.innerText = "Error: Please enter a valid email format.";
        return false;
    }
    if (phone.length !== 10 || isNaN(phone)) {
        errorBox.innerText = "Error: Phone number must contain exactly 10 digits.";
        return false;
    }
    if (category === "") {
        errorBox.innerText = "Error: Please select a participation category.";
        return false;
    }
    if (days < 1 || days > 3) {
        errorBox.innerText = "Error: Number of conference days must be between 1 and 3.";
        return false;
    }

    errorBox.innerText = "";
    return true;
}