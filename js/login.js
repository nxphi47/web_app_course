function templateLogin() {
    let template = `
    <form action="login.php" method="post">
        <div class="row">
            <label for="uname">User Name</label>
            <input type="text" id="uname" name="uname" placeholder="User name" required onkeyup="validateLogin()">
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required  onkeyup="validateLogin()">
        </div>
        <div class="row">
            <button class="button" id="login_button" disabled>Login</button>
        </div>
    </form>
    `;
    function onLogin() {
        if (validateLogin()) {
            console.log("process login");
        }
    }
    function bindHandler() {
        document.getElementById("uname").onkeyup = validateLogin;
        document.getElementById("password").onkeyup = validateLogin;
        document.getElementById("login_button").onclick = onLogin;
    }
    return {
        template: template,
        bindHandler: bindHandler
    }
}

function templateSignup() {
    let template = `
    <form action="login.php" method="post">
        <div class="row">
            <label for="fname">First name</label>
            <input type="text" id="fname" name="fname" placeholder="First name" required onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="lname">Last name</label>
            <input type="text" id="lname" name="lname" placeholder="Last name" required onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="uname">User name</label>
            <input type="text" id="uname" name="uname" placeholder="User name" required onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="pay_name">Credit Card Name</label>
            <input type="text" id="pay_name" name="pay_name" placeholder="Credit Card Name"  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="pay_card_num">Card Number</label>
            <input type="text" id="pay_card_num" name="pay_card_num" placeholder="Credit Card Number"  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="pay_card_expire">Credit Card Expiry</label>
            <input type="date" id="pay_card_expire" name="pay_card_expire" placeholder="Credit Card Expiry"  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="dev_name">Delivery Name</label>
            <input type="text" id="dev_name" name="dev_name" placeholder="Name for delivery"  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="dev_phone">Phone</label>
            <input type="number" id="dev_phone" name="dev_phone" placeholder="Phone"  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="dev_address">Address</label>
            <input type="text" id="dev_address" name="dev_address" placeholder="Address"  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <label for="postal">Postal Code</label>
            <input type="number" id="postal" name="postal" placeholder="postal code"  onkeyup="validateSignup()">
        </div>
        <div class="row">
            <button class="button" id="signup_button" disabled>Sign up</button>
        </div>
    </form>
    `;

    function onSignup() {
        if (validateSignup()) {
            console.log("process signup");
        }
    }

    function bindHandler() {
        document.getElementById("uname").onkeyup = validateSignup;
        document.getElementById("password").onkeyup = validateSignup;
        document.getElementById("signup_button").onclick = onSignup;
    }
    return {
        template: template,
        bindHandler: bindHandler
    }
}

function validateLogin() {
    let uname = document.getElementById("uname").value;
    let password = document.getElementById("password").value;
    let button = document.getElementById("login_button");

    let valid = (uname.length >= 4 && password.length >= 6);
    button.disabled = !valid;

    console.log("hello");
    return valid;
}


function validateSignup() {
    let uname = document.getElementById("uname").value;
    let password = document.getElementById("password").value;
    let button = document.getElementById("signup_button");

    let valid = (uname.length >= 4 && password.length >= 6);
    button.disabled = !valid;
    return valid;
}



function openTab(event, tabName) {
    let i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    let html_obj = (tabName === 'login' ? templateLogin(): templateSignup());
    document.getElementById("banner").innerHTML = html_obj.template;
    document.getElementById("tabcontent").style.display = "block";
    event.currentTarget.className += " active";

    html_obj.bindHandler();
}

// document.getElementById("default-tab").click();

// validateLogin();/*
// validateSignup();*/



