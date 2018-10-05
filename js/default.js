/*
Support functions.....

 */

function ajax_post(request, obj, callback, callback_error=null, url="php/ajax_gateway.php", async=true) {
    /*
    Usuall php/ajax_gateway.php
     */
    const xmlhttp = new XMLHttpRequest();

    const requestObject = {
        // request type
        request: request,
        // request user

        // request data
        data: obj
    };

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
            let repsonseObject = JSON.parse(this.responseText);
            callback(repsonseObject);
        }
        else {
            if (callback_error != null) {
                callback_error(this.error);
            }
            else {
                alert(`ERROR:...`);
            }

        }
    };

    xmlhttp.open("POST", url, async);
    xmlhttp.setRequestHeader("Content-Type", "application/json");

    xmlhttp.send(JSON.stringify(requestObject));
}



