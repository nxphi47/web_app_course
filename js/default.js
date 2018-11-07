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
        request: request,
        data: obj
    };


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



function validateEmail(string) {
    // var emailRegex = /^[\w-.]+@[A-Za-z]+(\.[A-za-z]+){0,2}\.[A-Za-z]{2,3}$/;
    var emailRegex = /^[\w-.]+@[A-Za-z]+/;
    return (typeof string === 'string' || string instanceof String) && emailRegex.test(string);
}

function validateIc(string) {
    var regex = /^[STFG]\d{7}[A-Z]$/;
    return (typeof string === 'string' || string instanceof String) && regex.test(string);
}

function validateUname(string) {
    let uname_regex = /^[A-Za-z0-9_]{1,100}$/;
    return (typeof string === 'string' || string instanceof String) && string.length >= 4 && uname_regex.test(string);
}

function validatePassword(string) {
    return (typeof string === 'string' || string instanceof String) && string.length >= 6;
}

function validateRealName(string) {
    let name_regex = /^[A-Za-z\s]{1,100}$/;
    return (typeof string === 'string' || string instanceof String) && name_regex.test(string);
}

function validateDateFuture(date) {
    if (date !== "0000-00-00") {
        return new Date(date) > new Date();
    }
    else {
        return false;
    }
}

function validatePhone(phone) {
    let phone_str = phone.toString();
    return phone_str.length >= 8;
}

function validatePostal(postal) {
    let postal_str = postal.toString();
    return postal_str.length === 6;
}

function validateCv2(string) {
    let cv = string.toString();
    return cv.length === 3;
}

function validateCardNum(string) {
    let num = string.toString();
    let regex = /^[0-9]{1,100}$/;
    return regex.test(num);
}

function validateExperience(string) {
    return (typeof string === 'string' || string instanceof String) && string.length > 1;
}


