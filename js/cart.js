function templateOrderItem(
    cart_id,
    item,
    quantity,
    onQuantityChange,
    onRemove,
) {
    let {id, title, price, note, desc, thumbnail, img_url} = item;

    let id_temp = `cart_${cart_id}-id_${id}`;

    const max_char_len = 200;
    let description = desc.substring(0, max_char_len) + (desc.length <= max_char_len ? "" : "...");

    let quantitySpinner = templateQuantitySpinner(id_temp, quantity);
    let template = `
    <li class="cart-item" id="item-${id_temp}">
        <img class="cart-item-img" src="${thumbnail}" alt="Not found" width="150" height="100">
        <div class="cart-item-content">
            <div class="cart-item-description">
                <h2>${title}</h2>
                <p>
                    ${description}
                </p>
            </div>
            <div class="cart-item-control">
                <h2>$${price}</h2>
                ${quantitySpinner}
            </div>
        </div>
    </li>
    `;

    // handler should only be called once the dom created!
    // let bindingHandler = function () {
    //     const quantity_up = document.getElementById(`quantity-up-${id_temp}`);
    //     const quantity_down = document.getElementById(`quantity-down-${id_temp}`);
    //     const quantity_input = document.getElementById(`quantity-input-${id_temp}`);
    //     const remove_button = document.getElementById(`remove-button-${id_temp}`);
    //
    //     quantity_up.onclick = function () {
    //         quantity_input.stepUp(1);
    //         onQuantityChange(quantity_input.value);
    //     };
    //     quantity_down.onclick = function () {
    //         quantity_input.stepDown(1);
    //         onQuantityChange(quantity_input.value);
    //     };
    //     quantity_input.onkeyup = function () {
    //         onQuantityChange(quantity_input.value);
    //     };
    //
    //     remove_button.onclick = onRemove;
    // };

    let bindingHandler = function () {
        quantitySpinnerHandler(id_temp, onQuantityChange, onRemove)
    };

    return {
        template: template,
        bindHandler: bindingHandler,
    }
}

function componentOrderItemList(where_id, cart, updateTotal) {
    let {cart_id, order_items} = cart;

    let calculateTotal = function () {
        let all_total = 0;
        order_items.forEach(function (order_item, index) {
            all_total += order_item.quantity * order_item.item.price;
        });

        console.log(`price = ${all_total}`);
        cart.orders_subtotal = all_total;
        cart.total = cart.orders_subtotal + cart.delivery_subtotal;
        console.log(`cart.orders_subtotal = ${cart.orders_subtotal}`);
        console.log(`cart.total = ${cart.total}`);

        updateTotal()
    };

    let orderListTemplateBinds = order_items.map(function (order_item, index) {
        let {item, quantity} = order_item;
        let onQuantityChange = function (new_value) {
            order_item.quantity = new_value;
            calculateTotal();
        };
        let onRemove = function () {
            cart.order_items = cart.order_items.filter(function (_order, _index) {
                return _order !== order_item;
            });
            componentOrderItemList(where_id, cart, updateTotal);
            calculateTotal();
        };
        return templateOrderItem(cart_id, item, quantity, onQuantityChange, onRemove);
    });

    let orderListTemplates = orderListTemplateBinds.map(function (x) {
        return x.template
    });
    let orderListHanlders = orderListTemplateBinds.map(function (x) {
        return x.bindHandler
    });

    let allOrderListTemplate = orderListTemplates.join("");

    let template = `
    <ul class="cart-item-list">
        ${allOrderListTemplate}
    </ul>
    `;

    // actually binding
    document.getElementById(where_id).innerHTML = template;

    // functions
    orderListHanlders.forEach(function (initHandler) {
        return initHandler()
    });

    calculateTotal();
}

function componentCartInfo(where_id, cart) {
    let templateUpdateSummary = function () {
        document.getElementById(`orders_subtotal`).innerHTML = `$${cart.orders_subtotal}`;
        document.getElementById(`delivery_subtotal`).innerHTML = `$${cart.delivery_subtotal}`;
        document.getElementById(`order_total`).innerHTML = `$${cart.total}`;
        document.getElementById(`orders_item`).innerHTML = `${cart.order_items.length}`;
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
                <form id="payment" class="payment">
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
                        <!--<label for="cv2">CV2</label>-->
                        <!--<input type="text" id="cv2" name="cv2" placeholder="e.g: 123" required>-->
                        <button class="button" id="place_order" >Place Order</button>
                    </div>
                    
                </form>
            </div>
        </div>

    </div>
    `;

    let onModalClose = function () {
        const modal = document.getElementById(`confirm`);
        modal.style.display = "none";
    };
    let onBuy = function () {
        alert("You have placed the order");

    };

    function bind() {
        document.getElementById("confirm_close").onclick = onModalClose;
        document.getElementById("place_order").onclick = onBuy;
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


let fakeCart = {
    cart_id: 1,
    order_items: generateFakeItemDataForCart(10),
    total: 0,
    delivery_subtotal: 1.2,
    orders_subtotal: 0,
};


function init() {
    componentCartInfo(`cart-wrapper`, fakeCart);
    itemBannersSlideShows('item-slideshow-wrapper', generateFakeItemData(10));


    document.getElementById("checkout").onclick = function () {
        openModal(fakeCart);
        console.log("hello")
    };
}


window.onload = init;