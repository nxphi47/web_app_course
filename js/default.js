/*
Support functions.....

 */

function ajax_post(request, obj, callback, callback_error=null, url="php/ajax_gateway.php", async=false) {
    /*
    Usuall php/ajax_gateway.php
     */
    const xmlhttp = new XMLHttpRequest();

    callback_error = callback_error || function (x) {console.log(`ERROR: ${x}`)};

    const requestObject = {
        // request type
        request: request,
        // request user

        // request data
        data: obj
    };

    console.log(requestObject);

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let responseObject = null;
            try {
                responseObject = JSON.parse(this.responseText);
                console.log(responseObject);
                if (responseObject.isSuccess) {
                    callback(responseObject.data);
                }
                else {
                    // console.log(`ERROR: ${responseObject.message}`);
                    callback_error(responseObject.message);
                }
            } catch (e) {
                console.log(this.responseText);
                alert(`Sorry! Error happened!`);
                throw e;
            }
        }
    };

    xmlhttp.open("POST", url, async);
    xmlhttp.setRequestHeader("Content-Type", "application/json");

    xmlhttp.send(JSON.stringify(requestObject));
}



function validateEmail(email) {
    var emailRegex = /^[\w-.]+@[A-Za-z]+(\.[A-za-z]+){0,2}\.[A-Za-z]{2,3}$/;
    return emailRegex.test(email);
}

function validateIc(ic) {
    var regex = /^[STFG]\d{7}[A-Z]$/;
    return regex.test(ic);
}

function validateUname(uname) {
    return uname.length >= 4;
}

function validatePassword(password) {
    return password.length >= 6;
}

function validateRealName(name) {
    return name.length > 0;
}

function validateDateFuture(date) {
    return new Date(date) > new Date();
}

function validatePhone(phone) {
    return phone.toString().length >= 8;
}

function validateExperience(exp) {
    return exp.length > 1;
}


