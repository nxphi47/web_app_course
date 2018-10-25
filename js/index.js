

// Testing
console.log("testing");

console.log("testing item list");


function generateFakeItemData(size) {
    let dataList = [];
    for (let i =0; i < size; i++) {
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

function generateFakeSlideData(size) {
    let dataList = [];
    for (let i =0; i < size; i++) {
        let item = {
            id: i,
            caption: `Pizza Caption ${i} good good!`,
            price: i * 10 + 1,
            img_url: (i % 2 === 0?`imgs/pizza_test.jpg`:`imgs/pizza_test_2.jpeg`),
            link: `www.google.com`
        };

        dataList.push(item);
    }

    return dataList;
}

function generateFakeSlideQuotes(size) {
    let dataList = [];
    for (let i =0; i < size; i++) {
        let item = {
            id: i,
            author: `Xuan Phi ${i}`,
            quote: `this is a very good product - ${i} !!!!!!`
        };

        dataList.push(item);
    }

    return dataList;
}



const itemListWrapperId = `item-list-wrapper`;

let main_menu = rootData.menu;

// componentItemList(itemListWrapperId, main_menu);


let auto_slide = templateSlideShow(`slideshow-wrapper`, generateFakeSlideData(5));


quoteSlideShows(`quote-slideshow-wrapper`, rootData.feedback);

function onAddToCart(cart) {
    // componentCartInfo(`cart-wrapper`, cart);
    const num_items = cart.order_items.map((x) => x.quantity).reduce((a, b) => a + b, 0);
    document.getElementById(`num_items`).innerHTML = `${num_items}`;
    document.getElementById(`total_price`).innerHTML = `$${cart.total}`;
}

itemBannersSlideShows('item-slideshow-wrapper', main_menu, onAddToCart);


