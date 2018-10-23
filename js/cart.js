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
    let description = desc.substring(0, max_char_len) + (desc.length <= max_char_len? "" : "...");

    let quantitySpinner = templateQuantitySpinner(id_temp);
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

    let bindingHandler = function () {quantitySpinnerHandler(id_temp, onQuantityChange, onRemove)};

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

    let orderListTemplates = orderListTemplateBinds.map(function (x) {return x.template});
    let orderListHanlders = orderListTemplateBinds.map(function (x) {return x.bindHandler});

    let allOrderListTemplate = orderListTemplates.join("");

    let template = `
    <ul class="cart-item-list">
        ${allOrderListTemplate}
    </ul>
    `;

    // actually binding
    document.getElementById(where_id).innerHTML = template;

    // functions
    orderListHanlders.forEach(function (initHandler) {return initHandler()});

    calculateTotal();
}

function componentCartInfo(where_id, cart) {
    let templateUpdateSummary = function() {
        document.getElementById(`orders_subtotal`).innerHTML = `$${cart.orders_subtotal}`;
        document.getElementById(`delivery_subtotal`).innerHTML = `$${cart.delivery_subtotal}`;
        document.getElementById(`order_total`).innerHTML = `$${cart.total}`;
    };

    componentOrderItemList(`cart-content-wrapper`, cart, templateUpdateSummary);

}


// Testing
function generateFakeItemData(size, type = 'Pizza') {
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



let fakeCart = {
    cart_id: 1,
    order_items: generateFakeItemData(10),
    total: 0,
    delivery_subtotal: 1.2,
    orders_subtotal: 0,
};

componentCartInfo(`cart-wrapper`, fakeCart);



