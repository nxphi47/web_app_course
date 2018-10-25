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

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            // document.getElementById("txtHint").innerHTML = this.responseText;
            // console.log(this.responseText);
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
                throw e;
            }


        }
    };

    xmlhttp.open("POST", url, async);
    xmlhttp.setRequestHeader("Content-Type", "application/json");

    xmlhttp.send(JSON.stringify(requestObject));
}


// cookie
// let user = rootData.user;
// let cookies = document.cookie.split("; ");
// let cart_cookie = cookies.filter((v) => v.split("=") === "cart");
//
// if (cart_cookie.length === 0) {
//     // create new cookie
//     'user_id', 'order_items', 'note', 'total', 'delivery_subtotal',
//     'orders_subtotal',
//     'dev_name', 'dev_phone', 'dev_address', 'postal',
//     'pay_name', 'pay_card_num', 'pay_card_expire', 'cv2'
//     cart_cookie = {
//         cart_id: 0,
//         user_id: user.id,
//
//     }
// }
// else {
//     cart_cookie = cart_cookie[0];
//
// }
//


