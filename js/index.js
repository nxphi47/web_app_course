
let main_menu = rootData.menu;

let promotions = main_menu.filter((x) => x.type.toLowerCase() === 'promotion');

let auto_slide = templateSlideShow(`slideshow-wrapper`, promotions);


quoteSlideShows(`quote-slideshow-wrapper`, rootData.feedback);

function onAddToCart(cart) {
    // componentCartInfo(`cart-wrapper`, cart);
    const num_items = cart.order_items.map((x) => x.quantity).reduce((a, b) => a + b, 0);
    document.getElementById(`num_items`).innerHTML = `${num_items}`;
    document.getElementById(`total_price`).innerHTML = `$${cart.total}`;
}

itemBannersSlideShows('item-slideshow-wrapper', main_menu, onAddToCart);


