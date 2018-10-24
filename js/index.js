

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
            img_url: `imgs/pizza_test.jpg`,
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
// componentItemList(itemListWrapperId, generateFakeItemDataForCart(10));


templateSlideShow(`slideshow-wrapper`, generateFakeSlideData(5));


quoteSlideShows(`quote-slideshow-wrapper`, generateFakeSlideQuotes(3));


itemBannersSlideShows('item-slideshow-wrapper', generateFakeItemData(10));




//
print_call_back = function (res) {console.log(res)};

console.log("default");
ajax_post("default", {}, print_call_back);
console.log();

console.log("users");
ajax_post("get_user", {}, print_call_back);
console.log();


