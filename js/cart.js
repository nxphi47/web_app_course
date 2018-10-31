function getPlaceHolder(item) {
    switch (item.type.toLowerCase()) {
        case "pizza":
            return "Thickness, add chili, ....";
        case 'beverage':
            return "Hot or normal...";
        default:
            return "Comment...";
    }
}


function templateOrderItem(
    cart_id,
    // item,
    // quantity,
    order_item,
    onQuantityChange,
    onRemove,
) {
    let {item, quantity, comment} = order_item;
    let {id, title, price, note, desc, thumbnail, images, promoted_price} = item;

    let id_temp = `cart_${cart_id}-id_${id}`;

    const max_char_len = 200;
    let description = desc.substring(0, max_char_len) + (desc.length <= max_char_len ? "" : "...");

    thumbnail = `thumbnails/${thumbnail}`;
    let quantitySpinner = templateQuantitySpinner(id_temp, quantity);

    let placeholder = getPlaceHolder(item);

    let price_tag = null;
    if (promoted_price > 0) {
        price_tag = `
        <div class="price-label">
            <span class="price-tag cart price-minus">$${price}</span>
            <span class="price-tag cart">$${promoted_price}</span>
        </div>
        
        `;
    }
    else {
        price_tag = `
        <div class="price-label">
            <span class="price-tag cart">$${price}</span>
        </div>
        `;
    }

    let template = `
    <li class="cart-item" id="item-${id_temp}">
        <div class="cart-item-content">
            <img class="cart-item-img" src="${thumbnail}" alt="Not found" width="150" height="100">
            <div class="cart-item-description">
                <h2>${title}</h2>
                <input type="text" 
                        id="comment-item-${id_temp}" 
                        name="item-comment"
                        class="item-comment"
                        value="${comment}" 
                        placeholder="${placeholder}">
            </div>
            
        </div>
        <div class="cart-item-control">
            ${price_tag}
            ${quantitySpinner}
        </div>
    </li>
    `;

    let onKeyUpComment = function (e) {
        order_item.comment = document.getElementById(`comment-item-${id_temp}`).value;
    };

    let onKeyDownComment = function (e) {
        var regex = new RegExp("^(=|#|@)$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (regex.test(key)) {
            event.preventDefault();
            return false;
        }
    };

    let bindingHandler = function () {
        quantitySpinnerHandler(id_temp, onQuantityChange, onRemove);
        document.getElementById(`comment-item-${id_temp}`).onkeyup = onKeyUpComment;
        document.getElementById(`comment-item-${id_temp}`).onkeypress = onKeyDownComment;
    };

    return {
        template: template,
        bindHandler: bindingHandler,
    }
}

function componentOrderItemList(where_id, cart, updateTotal) {
    let {cart_id, order_items} = cart;

    let calculateTotal = function (cart) {
        updateCart(cart);

        updateTotal()
    };

    let orderListTemplateBinds = order_items.map(function (order_item, index) {
        let {item, quantity} = order_item;
        let onQuantityChange = function (new_value) {
            order_item.quantity = parseInt(new_value);
            calculateTotal(cart);
            updateCurrentCart(rootData.cart, () => {
                componentCartInfo(`cart-wrapper`, cart)
            });
        };
        let onRemove = function () {
            console.log(cart);
            cart.order_items = cart.order_items.filter(function (_order, _index) {
                return _order.item !== item;
            });
            console.log(cart);
            componentOrderItemList(where_id, cart, updateTotal);
            calculateTotal(cart);
            updateCurrentCart(cart, () => {
                componentCartInfo(`cart-wrapper`, cart)
            });
        };
        // return templateOrderItem(cart_id, item, quantity, onQuantityChange, onRemove);
        return templateOrderItem(cart_id, order_item, onQuantityChange, onRemove);
    });

    let orderListTemplates = orderListTemplateBinds.map(function (x) {
        return x.template
    });
    let orderListHanlders = orderListTemplateBinds.map(function (x) {
        return x.bindHandler
    });

    let allOrderListTemplate = orderListTemplates.join("");

    let template;
    if (cart.order_items.length <= 0) {
        template = `
        <h2>You have no order items.</h2>
        `
    }
    else {
        template = `
        <ul class="cart-item-list">
            ${allOrderListTemplate}
        </ul>
        `;
    }

    // actually binding
    document.getElementById(where_id).innerHTML = template;

    // functions
    orderListHanlders.forEach(function (initHandler) {
        return initHandler()
    });

    calculateTotal(cart);
}

function componentCartInfo(where_id, cart) {
    let templateUpdateSummary = function () {
        document.getElementById(`orders_subtotal`).innerHTML = `$${cart.orders_subtotal}`;
        document.getElementById(`delivery_subtotal`).innerHTML = `$${cart.delivery_subtotal}`;
        document.getElementById(`order_total`).innerHTML = `$${cart.total}`;
        const num_items = cart.order_items.map((x) => x.quantity).reduce((a, b) => a + b, 0);
        document.getElementById(`orders_item`).innerHTML = `${num_items}`;
        document.getElementById(`num_items`).innerHTML = `${num_items}`;
        document.getElementById(`total_price`).innerHTML = `$${cart.total}`;
        document.getElementById("checkout").disabled = (cart.order_items.length <= 0);

    };

    componentOrderItemList(`cart-content-wrapper`, cart, templateUpdateSummary);

}


function confirmModalTemplate(cart) {
    template = `
    <div id="confirm" class="modal" style="display: block;">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" id="confirm_close">&times;</span>
            <div class="modal-content-inside">
                <h2>Payment: $${cart.total}</h2>
                <form id="payment" class="payment" onsubmit="function() return false;">
                    <div class="row">
                        <label for="pay_name">Full Name</label>
                        <input type="text" id="pay_name" name="pay_name" placeholder="Your full name on card" required>
                    </div>
                    <div class="row">
                        <label for="pay_card_num">Card Number</label>
                        <input type="number" id="pay_card_num" name="pay_card_num" placeholder="e.g: 12345678" required>
                    </div>
                    <div class="row">
                        <label for="pay_card_expire">Card Expiry Day</label>
                        <input type="date" id="pay_card_expire" name="pay_card_expire" required>
                    </div>
                    <div class="row">
                        <label for="cv2">CV2</label>
                        <input type="text" id="cv2" name="cv2" placeholder="e.g: 123" required>
                    </div>
                    <div class="row">
                        <button type="button" class="button" id="place_order" disabled>Place Order</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    `;

    let form_keys = ['pay_name', 'pay_card_num', 'pay_card_expire', 'cv2'];

    let onModalClose = function () {
        const modal = document.getElementById(`confirm`);
        modal.style.display = "none";
    };
    let onBuy = function () {
        // alert(`You have placed the order: ${JSON.stringify(cart)}`);
        if (confirm("Are you sure to place this order?")) {
            ajax_post("checkout", cart,
                function (out_cart) {
                    alert(`You have successfully place order number ${out_cart.cart_id}`);
                    window.location.href = "index.php";

                },
                function (message) {
                    alert(`ERROR occur: ${message}`);
                }
            )
        }
    };

    function validate() {
        let valid = true;
        form_keys.forEach((k) => {
            if (k === "pay_card_expire") {
                valid = valid && (cart[k] !== "0000-00-00");
                valid = valid && (new Date(cart[k]) > new Date());
            }
        });
        console.log(`valid ${valid}`);
        document.getElementById("place_order").disabled = !valid;
    }

    let onKeyUp = function (form_name) {
        cart[form_name] = document.getElementById(form_name).value;
        validate();
    };


    function bind() {
        document.getElementById("confirm_close").onclick = onModalClose;
        document.getElementById("place_order").onclick = onBuy;
        form_keys.forEach((k) => {
            if (k === "pay_card_expire") {
                document.getElementById(k).onchange = () => {
                    onKeyUp(k)
                };
            }
            else {
                document.getElementById(k).onkeyup = () => {
                    onKeyUp(k)
                };
            }
        });
    }

    return {
        template: template,
        bindHandler: bind,
    }
}


// confirmation controller
function openModal(cart) {
    const temps = confirmModalTemplate(cart);
    document.getElementById("modal-wrapper").innerHTML = temps.template;
    temps.bindHandler();
}


// Testing
function generateFakeItemDataForCart(size, type = 'Pizza') {
    let dataList = [];
    let quantity = [];
    let orderList = [];
    for (let i = 0; i < size; i++) {
        let item = {
            id: i,
            title: `${type} ${i}`,
            price: i * 10 + 1,
            note: `per piece`,
            desc: `This is the ${type} of the best of the best This is the ${type} of 
            the best of the best This is the ${type} of the best of the best 
            This is the ${type} of the best of the best This is the pizza 
            of the best of the best This is the ${type} of the best of 
            the best This is the ${type} of the best of the best This is 
            the ${type} of the best of the best This is the ${type} of the best of the best
             This is the ${type} of the best of the best
             This is the ${type} of the best of the best `,
            img_url: `imgs/pizza_test.jpg`,
            thumbnail: `imgs/pizza_test.jpg`,
        };

        // dataList.push(item);
        // quantity.push()
        orderList.push({
            item: item,
            quantity: i + 1
        })
    }

    return orderList;
}

function generateFakeItemData(size) {
    let dataList = [];
    for (let i = 0; i < size; i++) {
        let item = {
            id: i,
            title: `Pizza ${i}`,
            price: i * 10 + 1,
            note: `per piece`,
            desc: `This is the pizza of the best of the best This is the pizza of 
            the best of the best This is the pizza of the best of the best 
            This is the pizza of the best of the best This is the pizza 
            of the best of the best This is the pizza of the best of 
            the best This is the pizza of the best of the best This is 
            the pizza of the best of the best This is the pizza of the best of the best
             This is the pizza of the best of the best This is the pizza of the best of the best `,
            img_url: `imgs/pizza_test.jpg`,
            thumbnail: `imgs/pizza_test.jpg`,
        };

        dataList.push(item);
    }

    return dataList;
}


// let fakeCart = {
//     cart_id: 1,
//     order_items: rootData.menu.map((x) => {return {item: x, quantity: 1}}),
//     total: 0,
//     delivery_subtotal: 1.2,
//     orders_subtotal: 0,
// };
// console.log(fakeCart);

function onAddToCart(cart) {
    componentCartInfo(`cart-wrapper`, cart);
}

function deliveryKeyup(form_name) {
    rootData.cart[form_name] = document.getElementById(form_name).value;
}

function init() {

    componentCartInfo(`cart-wrapper`, rootData.cart);
    itemBannersSlideShows('item-slideshow-wrapper', rootData.menu, onAddToCart);

    document.getElementById("checkout").onclick = function () {
        openModal(rootData.cart);
        console.log("hello")
    };
}


window.onload = init;