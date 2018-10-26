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
    document.getElementById(tabName).style.display = "block";
    event.currentTarget.className += " active";
}


function getUserInfo() {
    let updateInfo = {
        fname: document.getElementById("fname").value,
        lname: document.getElementById("lname").value,
        email: document.getElementById("email").value,
    };
    return updateInfo;
}

function initUserInfo() {
    document.getElementById("fname").value = rootData.user.fname;
    document.getElementById("lname").value = rootData.user.lname;
    document.getElementById("email").value = rootData.user.email;
}

function validateUserInfo() {
    let updateInfo = getUserInfo();
    if (updateInfo.fname.length <= 0) {
        alert("Invalid first name");
        return false;
    }
    if (updateInfo.lname.length <= 0) {
        alert("Invalid Last name");
        return false;
    }
    var emailRegex = /^[\w-.]+@[A-Za-z]+(\.[A-za-z]+){0,2}\.[A-Za-z]{2,3}$/;
    if (!emailRegex.test(updateInfo.email)) {
        alert("Invalid Last name");
        return false;
    }

    return true;
}

function updateUserInfo() {
    if (validateUserInfo()) {
        let updateInfo = getUserInfo();
        updateInfo.id = rootData.user.id;
        ajax_post("update_user_info", updateInfo, function (out) {
            rootData.user = out;
            initUserInfo();
        })
    }
}


function generateUserInfo() {

}


function generateCreditCards() {

    let rows = rootData.credit_cards.map((card) => {
        let {pay_name, pay_card_expire, pay_card_num} = card;
        return `
       <tr>
            <td>${pay_name}</td>
            <td>${pay_card_num}</td>
            <td>${pay_card_expire}</td>
        </tr>
        `;
    }).join(" ");

    let template = `
    <table class="carts-table">
        <tr>
            <th>Card Name</th>
            <th>Card Number</th>
            <th>Expiry Date</th>
        </tr>
        ${rows}
    </table>
    `;

    document.getElementById("user-tab-credit_cards").innerHTML = template;
}

function onSubmitNewCreditCard() {
    let card = {
        pay_name: document.getElementById("pay_name").value,
        pay_card_num: document.getElementById("pay_card_num").value,
        pay_card_expire: document.getElementById("pay_card_expire").value,
    };

    return confirm("Are you sure to add this credit card?");
}


initUserInfo();
generateCreditCards();
document.getElementById("default-tab").click();



















