// ---------------- ITEM BANNER -------------------
function templateQuantitySpinner(id_temp, quantity) {
    let template = `
    <div class="quantity">
        <input id="quantity-input-${id_temp}" type="number" min="1" max="9" step="1" value="${quantity}">
        <div class="quantity-nav">
            <div class="quantity-button quantity-up" id="quantity-up-${id_temp}">+</div>
            <div class="quantity-button quantity-down" id="quantity-down-${id_temp}">-</div>
        </div>
    </div>
    <button class="button remove-button" id="remove-button-${id_temp}">Remove</button>
    `;

    return template;
}

function quantitySpinnerHandler(id_temp, onQuantityChange = null, onRemove = null) {
    const quantity_up = document.getElementById(`quantity-up-${id_temp}`);
    const quantity_down = document.getElementById(`quantity-down-${id_temp}`);
    const quantity_input = document.getElementById(`quantity-input-${id_temp}`);
    const remove_button = document.getElementById(`remove-button-${id_temp}`);
    if (!onQuantityChange) {
        onQuantityChange = function (x) {
        }
    }
    if (!onRemove) {
        onRemove = function (x) {
        }
    }

    quantity_up.onclick = function () {
        quantity_input.stepUp(1);
        onQuantityChange(quantity_input.value);
    };
    quantity_down.onclick = function () {
        quantity_input.stepDown(1);
        onQuantityChange(quantity_input.value);
    };
    quantity_input.onkeyup = function () {
        onQuantityChange(quantity_input.value);
    };

    remove_button.onclick = onRemove;
}


function templateItemBanner(
    item,
    where_id,
    banner_temp = "item_banner",
    img_temp = "item_img",
    add_cart_temp = "add_cart",
    modal_temp = "item_modal",
    modal_close_temp = "item_modal_close",
    modal_add_cart_temp = "add_cart_modal",
) {
    let {id, title, price, desc, unit, thumbnail, images, promoted_price, diet} = item;

    thumbnail = `thumbnails/${thumbnail}`;
    images = images.split(";").map((x) => `images/${x}`);


    let diet_url;
    switch (diet) {
        case 1:
            diet_url = 'imgs/vegan.jpeg';
            break;
        case 2:
            diet_url = 'imgs/halal.png';
            break;
        default:
            diet_url = '';
    }

    let dietTemp = (diet !== 0) ? `
    <span class="diet">
        <img src="${diet_url}" width="50" height="50">
    </span>
    ` : '';

    let template = `
    <div class="responsive" id="${where_id}_${banner_temp}_${id}">
        <div class="item-banner">
            <a id="${where_id}_${img_temp}_${id}">
                <img src="${thumbnail}" alt="Not found" width="600" height="400">
            </a>
            <div class="desc">
                <span class="desc">
                    <span class="title">
                        ${title}
                        ${dietTemp}
                    </span>
                    <div class="price-tag">
                        <span class="price${promoted_price > 0 ? ' minus' : ''}">$${price}</span>
                        <span class="promoted-price" style="display: ${promoted_price > 0 ? 'inline-block' : 'none'};">$${promoted_price}</span>
                    </div>
                    
                    <span class="note">per ${unit}</span>
                </span>
                <button class="button desc" id="${where_id}_${add_cart_temp}_${id}">Add to Cart</button>
            </div>
        </div>
    </div>
    <!--Pop up window here-->
    <div id="${where_id}_${modal_temp}_${id}" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" id="${where_id}_${modal_close_temp}_${id}">&times;</span>
            <div class="modal-content-inside">
                <div class="image">
                    <img src="${images[0]}" alt="Image Not found" width="600" height="400">
                </div>
                <div class="detail">
                    <span class="title">${title}</span>
                    <p>${desc}</p>
                    <hr>
                    <div class="control">
                        <div class="pricing">
                            <span class="price">$${price}</span>
                            <span class="note">per ${unit}</span>
                        </div>
                        <button class="button" id="${where_id}_${modal_add_cart_temp}_${id}">Add to Cart</button>
                    </div>
                </div>
                
            </div>
        </div>
    
    </div>
    `;
    return template
}


function updateCart(cart) {
    let all_total = 0;
    cart.order_items.forEach(function (order_item, index) {
        all_total += order_item.quantity * (order_item.item.promoted_price > 0 ? order_item.item.promoted_price : order_item.item.price);
    });

    cart.orders_subtotal = all_total;
    cart.delivery_subtotal = (cart.order_items.length > 0) ? 1.2 : 0;
    cart.total = cart.orders_subtotal + cart.delivery_subtotal;
}

function updateCartLabel() {
    let currentCart = rootData.cart;
    let num_items = 0;
    currentCart.order_items.forEach((order, index) => {
        num_items += order.quantity;
    });
    updateCart(currentCart);
    document.getElementById("num_items").innerHTML = num_items.toString();
    document.getElementById("total_price").innerHTML = `$${currentCart.total}`;

}

function updateCurrentCart(cart = null, callback = null) {
    updateCart(cart);

    ajax_post("add_to_cart", cart, function (new_cart) {
        rootData.cart = new_cart;
        if (callback != null) {
            callback(rootData.cart);
        }
    })
}

function displayCartUpdate() {
    document.getElementById("link-cart").classList.add("active");
    setTimeout(() => {
        document.getElementById("link-cart").classList.remove("active");
    }, 1000);
}


function addToCart(item, callback = null) {
    let currentCart = rootData.cart;
    let menu = rootData.menu;
    if (currentCart.order_items.map((x) => x.item.id).includes(item.id)) {
        currentCart.order_items.filter((x) => x.item.id == item.id)[0].quantity += 1;
        console.log(currentCart);
    }
    else {
        currentCart.order_items.push({
            item: item,
            quantity: 1,
            comment: "",
        })
    }
    updateCartLabel();
    updateCurrentCart(rootData.cart, callback);
    displayCartUpdate();
}

function bindHandlersItemBanner(
    item,
    where_id,
    banner_temp = "item_banner",
    img_temp = "item_img",
    add_cart_temp = "add_cart",
    modal_temp = "item_modal",
    modal_close_temp = "item_modal_close",
    modal_add_cart_temp = "add_cart_modal",
    on_add_cart = null,
) {
    let onClickImg = function () {
        let modal = document.getElementById(`${where_id}_${modal_temp}_${item.id}`);
        modal.classList.add("display");
    };

    let onModalClose = function () {
        let modal = document.getElementById(`${where_id}_${modal_temp}_${item.id}`);
        modal.classList.remove("display");
    };

    let onAdd = function (e) {
        console.log(`click add on item ${item.id}`);
        console.log(item);
        addToCart(item, on_add_cart);
    };
    document.getElementById(`${where_id}_${img_temp}_${item.id}`).onclick = onClickImg;
    document.getElementById(`${where_id}_${add_cart_temp}_${item.id}`).onclick = onAdd;
    document.getElementById(`${where_id}_${modal_add_cart_temp}_${item.id}`).onclick = onAdd;
    document.getElementById(`${where_id}_${modal_close_temp}_${item.id}`).onclick = onModalClose;
}

function componentItemList(where_id, data_list, display_diet = true) {
    let itemListTemplate = `
    <div class="menu-control">
        <div class="menu-filter">
            <span class="menu-filter-label">Sort:</span>
            <button class="button button-menu-filter" id="${where_id}-sort_button_low_high">
                Low to high
            </button>
            <button class="button button-menu-filter" id="${where_id}-sort_button_high_low">
                High to Low
            </button>
            
        </div>
        <div class="menu-filter" ${!display_diet ? 'style="display: none;"' : ''}>
            <span class="menu-filter-label">Filter:</span>
            <button class="button button-menu-filter" id="${where_id}-filter-veg">
                Vegetarian
                <img src="imgs/vegan.jpeg" width="20" height="20">
            </button>
            <button class="button button-menu-filter" id="${where_id}-filter-halal">
                Halal
                <img src="imgs/halal.png" width="20" height="20">
            </button>
        </div>
    </div>
    
    <div id="${where_id}-item-list"></div>
    `;

    let currentDietIndex = 0;
    let currentSortIndex = 0; //

    let bindFilterButton = function (element, filter_index, remove_active_elements) {
        element.onclick = function () {
            if (currentDietIndex === filter_index) {
                currentDietIndex = 0;
                element.classList.remove('active');
            }
            else {
                currentDietIndex = filter_index;
                element.classList.add('active');
                remove_active_elements.forEach((x) => x.classList.remove('active'));
            }
            generateItemFilterList();
        };
    };

    let bindSortButton = function (element, sort_index, remove_active_elements) {
        element.onclick = function () {
            if (currentSortIndex === sort_index) {
                currentSortIndex = 0;
                element.classList.remove('active');
            }
            else {
                currentSortIndex = sort_index;
                element.classList.add('active');
                remove_active_elements.forEach((x) => x.classList.remove('active'));
            }
            generateItemFilterList();
        }
    };

    let controlHandler = function () {
        let veg_button = document.getElementById(`${where_id}-filter-veg`);
        let halal_button = document.getElementById(`${where_id}-filter-halal`);
        let high_low_button = document.getElementById(`${where_id}-sort_button_high_low`);
        let low_high_button = document.getElementById(`${where_id}-sort_button_low_high`);
        bindFilterButton(veg_button, 1, [halal_button]);
        bindFilterButton(halal_button, 2, [veg_button]);

        bindSortButton(low_high_button, 1, [high_low_button]);
        bindSortButton(high_low_button, 2, [low_high_button]);
    };

    let generateItemFilterList = function () {
        let filteredMenu = JSON.parse(JSON.stringify(data_list));
        // let filteredMenu;
        if (currentDietIndex !== 0) {
            // filteredMenu = data_list;
            filteredMenu = data_list.filter((x) => x.diet === currentDietIndex);
        }

        if (currentSortIndex === 1) {
            // low to high
            filteredMenu = filteredMenu.sort((a, b) =>
                Math.min(a.price, a.promoted_price > 0 ? a.promoted_price : 100000) - Math.min(b.price, b.promoted_price > 0 ? b.promoted_price : 1000000))
        }
        else if (currentSortIndex === 2) {
            // high to low
            filteredMenu = filteredMenu.sort((a, b) =>
                Math.min(b.price, b.promoted_price > 0 ? b.promoted_price : 100000) - Math.min(a.price, a.promoted_price > 0 ? a.promoted_price : 1000000))
        }

        generateItems(filteredMenu)
    };


    let generateItems = function (data) {
        let itemHtmls = data.map(function (item) {
            return templateItemBanner(item, where_id);
        }).join("");

        let componentListTemplate = `
        <div class="item-list" id="main-item-list">
            ${itemHtmls}
        </div>
        <div class="clearfix"></div>
        `;
        document.getElementById(`${where_id}-item-list`).innerHTML = componentListTemplate;
        data.forEach(function (item) {
            return bindHandlersItemBanner(item, where_id)
        });
    };


    // actually binding
    document.getElementById(where_id).innerHTML = itemListTemplate;
    // functions
    controlHandler();
    generateItemFilterList();

}


// -------------- COMMENT SLIDE SHOWS -------------------

function autoSlide(nextSlide, interval = 5000) {
    let auto = setInterval(nextSlide, interval);
    return auto;
}

// Slide show for promotions
function templateSlide(index, slide, totalSlides) {
    let {id, title, price, desc, unit, thumbnail, images, promoted_price, diet} = slide;
    let img_url = "images/" + images;
    const where_id = "slide-show";
    const modal_add_cart_temp = "slide-show-add";
    const modal_close_temp = "slide-show-close";
    const modal_temp = 'slide-show-modal';

    let template = `
    <div class="slide fade">
        <div class="number-text">${index + 1} / ${totalSlides}</div>
        <a href="vascript:void(0);" id="slide-${id}"><img class="slide-img" src="${img_url}"></a>
        <div class= "bordercaption">
            <div class="caption">${title}</div>
        </div>
        <div id="${where_id}_${modal_temp}_${id}" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" id="${where_id}_${modal_close_temp}_${id}">&times;</span>
            <div class="modal-content-inside">
                <div class="image">
                    <img src="${img_url}" alt="Image Not found" width="600" height="400">
                </div>
                <div class="detail">
                    <span class="title">${title}</span>
                    <p>${desc}</p>
                    <hr>
                    <div class="control">
                        <div class="pricing">
                            <span class="price">$${price}</span>
                            <span class="note">per ${unit}</span>
                        </div>
                        <button class="button" id="${where_id}_${modal_add_cart_temp}_${id}">Add to Cart</button>
                    </div>
                </div>
                
            </div>
        </div>
    
    </div>
    </div>
    `;

    return template
}

function templateSlideDot(index, slide, totalSlides) {
    let {id, caption, link, img_url} = slide;
    let template = `
    <span class="dot" id="slide_show_dot_${index}_${id}"></span>
    `;
    return template
}


function templateSlideShow(where_id, slideShows) {
    const totalSlides = slideShows.length;

    let slideHtmls = slideShows.map(function (slide, index) {
        return templateSlide(index, slide, totalSlides);
    }).join("");

    let slideDotHtmls = slideShows.map(function (slide, index) {
        return templateSlideDot(index, slide, totalSlides);
    }).join("");


    let slideShowHtml = `
    <div class="slideshow">
        ${slideHtmls}
        <a class="prev" id="prev_button" >&#10094;</a>
        <a class="next" id="next_button" >&#10095;</a>
    </div>
    <br>
    <!-- The dots/circles -->
    <div class="dot-line">
        ${slideDotHtmls}
    </div>
    `;

    const _where_id_ = "slide-show";
    const modal_add_cart_temp = "slide-show-add";
    const modal_close_temp = "slide-show-close";
    const modal_temp = 'slide-show-modal';

    let currentIndex = 0;

    function showSlides(num) {
        let slides = document.getElementsByClassName("slide");
        let dots = document.getElementsByClassName("dot");

        if (num > totalSlides - 1) {
            currentIndex = 0;
        }
        if (num < 0) {
            currentIndex = totalSlides - 1;
        }

        for (let slide of slides) {
            slide.style.display = "none";
        }
        for (let dot of dots) {
            dot.className = dot.className.replace(" active", "");
        }
        // dots.forEach(function (dot) {dot.className = dot.className.replace(" active", "")});

        slides[currentIndex].style.display = "block";
        dots[currentIndex].className += " active";
    }

    // Next/previous controls
    function plusSlides(n) {
        showSlides(currentIndex += n);
    }

    // Thumbnail images controls
    function currentSlide(n) {
        showSlides(currentIndex = n);
    }

    document.getElementById(where_id).innerHTML = slideShowHtml;

    document.getElementById(`prev_button`).onclick = function () {
        plusSlides(-1)
    };
    document.getElementById(`next_button`).onclick = function () {
        plusSlides(1)
    };


    slideShows.forEach((slide, index) => {
        // slide-${id}
        document.getElementById(`slide-${slide.id}`).onclick = function () {
            document.getElementById(`${_where_id_}_${modal_temp}_${slide.id}`).classList.add("display");
        };
        document.getElementById(`${_where_id_}_${modal_close_temp}_${slide.id}`).onclick = function () {
            document.getElementById(`${_where_id_}_${modal_temp}_${slide.id}`).classList.remove("display");
        };
        document.getElementById(`${_where_id_}_${modal_add_cart_temp}_${slide.id}`).onclick = function () {
            addToCart(slide, onAddToCart);
        }
    });

    let dots = document.getElementsByClassName("dot");
    for (let i = 0; i < dots.length; i++) {
        dots[i].onclick = function () {
            currentSlide(i);
        };
    }

    showSlides(currentIndex);
    return null;
}

// Slide show for Quotes
function templateQuoteSlide(index, slide, totalSlides) {
    let {id, user_id, stars, note} = slide;

    let template = `
    <div class="quote-slide">
        <q>${note}</q>
        <p class="author">- ${user_id.uname}</p>
    </div>
    `;

    return template
}

function templateQuoteDot(index, slide, totalSlides) {
    let {id, author, quote} = slide;
    let template = `
    <span class="quote-slide-dot" id="quote_dot_${index}_${id}"></span>
    `;

    return template;
}

function quoteSlideShows(where_id, quoteSlides) {
    const totalSlides = quoteSlides.length;

    let slideHtmls = quoteSlides.map(function (slide, index) {
        return templateQuoteSlide(index, slide, totalSlides);
    }).join("");

    let slideDotHtmls = quoteSlides.map(function (slide, index) {
        return templateQuoteDot(index, slide, totalSlides);
    }).join("");


    let slideShowHtml = `
    <div class="quote-slideshow">
        ${slideHtmls}
        <a class="quote-slide-prev" id="quote_prev_button" >&#10094;</a>
        <a class="quote-slide-next" id="quote_next_button" >&#10095;</a>
    </div>
    <br>
    <!-- The dots/circles -->
    <div class="dot-line">
        ${slideDotHtmls}
    </div>
    `;

    let currentIndex = 0;

    function showSlides(num) {
        let slides = document.getElementsByClassName("quote-slide");
        let dots = document.getElementsByClassName("quote-slide-dot");

        if (num > totalSlides - 1) {
            currentIndex = 0;
        }
        if (num < 0) {
            currentIndex = totalSlides - 1;
        }

        for (let slide of slides) {
            slide.style.display = "none";
        }
        for (let dot of dots) {
            dot.className = dot.className.replace(" active", "");
        }

        slides[currentIndex].style.display = "block";
        dots[currentIndex].className += " active";
    }

    // Next/previous controls
    function plusSlides(n) {
        showSlides(currentIndex += n);
    }

    // Thumbnail images controls
    function currentSlide(n) {
        showSlides(currentIndex = n);
    }

    document.getElementById(where_id).innerHTML = slideShowHtml;

    document.getElementById(`quote_prev_button`).onclick = function () {
        plusSlides(-1)
    };
    document.getElementById(`quote_next_button`).onclick = function () {
        plusSlides(1)
    };

    let dots = document.getElementsByClassName("quote-slide-dot");
    for (let i = 0; i < dots.length; i++) {
        dots[i].onclick = function () {
            currentSlide(i)
        };
    }

    showSlides(currentIndex);
}


// Slide show for Item list
const slide_banner_temp = "slide_item_banner";
const slide_img_temp = "slide_item_img";
const slide_add_cart_temp = "slide_add_cart";
const slide_modal_temp = "slide_item_modal";
const slide_modal_close_temp = "slide_item_modal_close";
const slide_modal_add_cart_temp = "slide_add_cart_modal";

function slideItemBanner(item, where_id) {
    return templateItemBanner(
        item, where_id, slide_banner_temp, slide_img_temp, slide_add_cart_temp,
        slide_modal_temp, slide_modal_close_temp, slide_modal_add_cart_temp
    );
}

function bindHandlersSlideItemBanner(item, where_id, on_add_cart = null) {
    return bindHandlersItemBanner(
        item, where_id, slide_banner_temp, slide_img_temp, slide_add_cart_temp,
        slide_modal_temp, slide_modal_close_temp, slide_modal_add_cart_temp, on_add_cart
    )
}

function templateSlideItemBanner(where_id, index, itemList) {

    // console.log(itemList);
    let itemBanners = itemList.map(function (item) {
        return slideItemBanner(item, where_id)
    }).join("");
    // console.log(itemBanners);
    let template = `
    <div class="item-slide">
        ${itemBanners}
    </div>
    `;

    return template
}

function templateSlideItemDot(where_id, index, slide) {
    // let {id, author, quote} = slide;
    let template = `
    <span class="item-slide-dot" id="${where_id}_item_dot_${index}"></span>
    `;

    return template;
}

function itemBannersSlideShows(where_id, highlightItems, on_add_cart = null) {

    let itemSetSlides = [];
    let currentSlide = [];
    highlightItems.forEach(function (item, index) {
        currentSlide.push(item);

        if (currentSlide.length === 3) {
            itemSetSlides.push(currentSlide);
            currentSlide = [];
        }
    });
    if (currentSlide.length !== 0) {
        itemSetSlides.push(currentSlide);
    }

    let itemSetSlideHtmls = itemSetSlides.map(function (itemSet, index) {

        return templateSlideItemBanner(where_id, index, itemSet);
    }).join("");

    let itemSetSlideDotHtmls = itemSetSlides.map(function (itemSet, index) {
        return templateSlideItemDot(where_id, index, itemSet);
    }).join("");


    let slideShowHtml = `
    <div class="item-slideshow">
        <a class="item-slide-prev" id="item_prev_button" >&#10094;</a>
        <div class="item-slideshow-container">
            ${itemSetSlideHtmls}
        </div>
        
        <a class="item-slide-next" id="item_next_button" >&#10095;</a>
    </div>
    <!-- The dots/circles -->
    <div class="dot-line">
        ${itemSetSlideDotHtmls}
    </div>
    `;

    let currentIndex = 0;

    function showSlides(num) {
        let slides = document.getElementsByClassName("item-slide");
        let dots = document.getElementsByClassName("item-slide-dot");


        if (num > itemSetSlides.length - 1) {
            currentIndex = 0
        }
        if (num < 0) {
            currentIndex = itemSetSlides.length - 1
        }

        for (let slide of slides) {
            slide.style.display = "none";
        }
        for (let dot of dots) {
            dot.className = dot.className.replace(" active", "");
        }

        slides[currentIndex].style.display = "block";
        dots[currentIndex].className += " active";
    }

    // Next/previous controls
    function plusSlides(n) {
        showSlides(currentIndex += n);
    }

    // Thumbnail images controls
    function openCurrentSlide(n) {
        showSlides(currentIndex = n);
    }

    document.getElementById(where_id).innerHTML = slideShowHtml;


    showSlides(currentIndex);


    // bind events
    document.getElementById(`item_prev_button`).onclick = function () {
        plusSlides(-1)
    };
    document.getElementById(`item_next_button`).onclick = function () {
        plusSlides(1)
    };

    let dots = document.getElementsByClassName("item-slide-dot");
    for (let i = 0; i < dots.length; i++) {
        dots[i].onclick = function () {
            openCurrentSlide(i)
        };
    }

    highlightItems.forEach(function (item) {
        return bindHandlersSlideItemBanner(item, where_id, on_add_cart)
    });
}


updateCartLabel();

