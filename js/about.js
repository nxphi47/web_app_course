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


function validateCareer() {
    let fname = document.getElementById('fname').value;
    let lname = document.getElementById('lname').value;
    let email = document.getElementById('email').value;
    let ic = document.getElementById('ic').value;
    let phone = document.getElementById('phone').value;
    let experience = document.getElementById('experience').value;

    let valid = true;
    valid = valid && validateRealName(fname);
    valid = valid && validateRealName(lname);
    valid = valid && validateEmail(email);
    valid = valid && validateIc(ic);
    valid = valid && validatePhone(phone);
    valid = valid && validateExperience(experience);

    if (!valid) {
        alert(`Invalid inputs:`);
    }

    return valid;
}

function validateContact() {
    let name = document.getElementById('name').value;
    let email = document.getElementById('user_email').value;
    let question = document.getElementById('question').value;

    let valid = true;
    valid = valid && validateRealName(name);
    valid = valid && validateEmail(email);
    valid = valid && validateExperience(question);

    if (!valid) {
        alert(`Invalid inputs:`);
    }

    return valid;
}




document.getElementById("default-tab").click();

