// ---------------- ITEM BANNER -------------------
function templateItemBanner(
    item,
    banner_temp = "item_banner",
    img_temp = "item_img",
    add_cart_temp = "add_cart",
    modal_temp = "item_modal",
    modal_close_temp = "item_modal_close",
    modal_add_cart_temp = "add_cart_modal",
) {
    // item.id, item.title, item.price, item.note, item.desc, item.thumbnail, item.img_url,
    let {id, title, price, note, desc, thumbnail, img_url} = item;

    let template = `
    <div class="responsive" id="${banner_temp}_${id}">
        <div class="item-banner">
            <a href="#" id="${img_temp}_${id}">
                <img src="${thumbnail}" alt="Not found" width="600" height="400">
            </a>
            <div class="desc">
                <span class="desc">
                    <span class="title">${title}</span>
                    <span class="price">$${price}</span>
                    <span class="note">${note}</span>
                </span>
                <button class="button desc" id="${add_cart_temp}_${id}">Add to Cart</button>
            </div>
        </div>
    </div>
    <!--Pop up window here-->
    <div id="${modal_temp}_${id}" class="modal" style="display: none;">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" id="${modal_close_temp}_${id}">&times;</span>
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
                            <span class="note">${note}</span>
                        </div>
                        <button class="button" id="${modal_add_cart_temp}_${id}">Add to Cart</button>
                    </div>
                </div>
                
            </div>
        </div>
    
    </div>
    `;
    return template
}

function bindHandlersItemBanner(
    item,
    banner_temp = "item_banner",
    img_temp = "item_img",
    add_cart_temp = "add_cart",
    modal_temp = "item_modal",
    modal_close_temp = "item_modal_close",
    modal_add_cart_temp = "add_cart_modal",
) {
    let onClickImg = function () {
        const modal = document.getElementById(`${modal_temp}_${item.id}`);
        modal.style.display = "block"
    };

    let onModalClose = function () {
        const modal = document.getElementById(`${modal_temp}_${item.id}`);
        modal.style.display = "none";
    };

    let onAdd = function (e) {
        console.log(`click add on item ${item.id}`);
        console.log(item);
    };
    // console.log(`get item ${img_temp}_${item.id}`);
    // console.log(document.getElementById(`${img_temp}_${item.id}`));
    document.getElementById(`${img_temp}_${item.id}`).onclick = onClickImg;
    document.getElementById(`${add_cart_temp}_${item.id}`).onclick = onAdd;
    document.getElementById(`${modal_add_cart_temp}_${item.id}`).onclick = onAdd;
    document.getElementById(`${modal_close_temp}_${item.id}`).onclick = onModalClose;
}

function componentItemList(where_id, data_list) {
    let itemHtmls = data_list.map(templateItemBanner).join("");

    let componentListTemplate = `
    <div class="item-list" id="main-item-list">
        ${itemHtmls}
    </div>
    <div class="clearfix"></div>
    `;

    // actually binding
    document.getElementById(where_id).innerHTML = componentListTemplate;

    // functions
    data_list.forEach(bindHandlersItemBanner);

    return componentListTemplate;
}


// -------------- COMMENT SLIDE SHOWS -------------------

// Slide show for promotions
function templateSlide(index, slide, totalSlides) {
    let {id, caption, link, img_url} = slide;

    let template = `
    <div class="slide fade">
        <div class="number-text">${index + 1} / ${totalSlides}</div>
        <a target="_blank" href="${link}"><img class="slide-img" src="${img_url}"></a>
        <div class="caption">${caption}</div>
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
    <div style="text-align:center">
        ${slideDotHtmls}
    </div>
    `;

    let currentIndex = 0;

    function showSlides(num) {
        let slides = document.getElementsByClassName("slide");
        let dots = document.getElementsByClassName("dot");

        // console.log(slides);
        // console.log(dots);
        if (num > totalSlides - 1) {
            currentIndex = 0;
        }
        if (num < 0) {
            currentIndex = totalSlides - 1;
        }

        // slides.forEach(function (slide) {});
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

    // Thumbnail image controls
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

    let dots = document.getElementsByClassName("dot");
    for (let i = 0; i < dots.length; i++) {
        dots[i].onclick = function () {
            currentSlide(i)
        };
    }

    showSlides(currentIndex);
}

// Slide show for Quotes
function templateQuoteSlide(index, slide, totalSlides) {
    let {id, author, quote} = slide;

    let template = `
    <div class="quote-slide">
        <q>${quote}</q>
        <p class="author">- ${author}</p>
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
    <div style="text-align:center">
        ${slideDotHtmls}
    </div>
    `;

    let currentIndex = 0;

    function showSlides(num) {
        let slides = document.getElementsByClassName("quote-slide");
        let dots = document.getElementsByClassName("quote-slide-dot");

        // console.log(slides);
        // console.log(dots);
        if (num > totalSlides - 1) {
            currentIndex = 0;
        }
        if (num < 0) {
            currentIndex = totalSlides - 1;
        }

        // slides.forEach(function (slide) {});
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

    // Thumbnail image controls
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

    let dots = document.getElementsByClassName("dot");
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

function slideItemBanner(item) {
    return templateItemBanner(
        item, slide_banner_temp, slide_img_temp, slide_add_cart_temp,
        slide_modal_temp, slide_modal_close_temp, slide_modal_add_cart_temp
    );
}

function bindHandlersSlideItemBanner(item) {
    // console.log(item);
    return bindHandlersItemBanner(
        item, slide_banner_temp, slide_img_temp, slide_add_cart_temp,
        slide_modal_temp, slide_modal_close_temp, slide_modal_add_cart_temp
    )
}

function templateSlideItemBanner(index, itemList) {

    let itemBanners = itemList.map(slideItemBanner).join("");

    let template = `
    <div class="item-slide">
        ${itemBanners}
    </div>
    `;

    return template
}

function templateSlideItemDot(index, slide) {
    // let {id, author, quote} = slide;
    let template = `
    <span class="item-slide-dot" id="item_dot_${index}"></span>
    `;

    return template;
}

function itemBannersSlideShows(where_id, highlightItems) {

    let itemSetSlides = [];
    let currentSlide = [];
    highlightItems.forEach(function (item, index) {
        currentSlide.push(item);

        if (currentSlide.length === 3) {
            // finish 1 set
            // console.log(`finish set in index ${index}`);
            itemSetSlides.push(currentSlide);
            currentSlide = [];
        }

    });
    if (currentSlide.length !== 0) {
        itemSetSlides.push(currentSlide);
    }

    let itemSetSlideHtmls = itemSetSlides.map(function (itemSet, index) {
        return templateSlideItemBanner(index, itemSet);
    }).join("");

    let itemSetSlideDotHtmls = itemSetSlides.map(function (itemSet, index) {
        return templateSlideItemDot(index, itemSet);
    }).join("");


    let slideShowHtml = `
    <div class="item-slideshow">
        <a class="item-slide-prev" id="item_prev_button" >&#10094;</a>
        <div class="item-slideshow-container">
            ${itemSetSlideHtmls}
        </div>
        
        <a class="item-slide-next" id="item_next_button" >&#10095;</a>
    </div>
    <br>
    <!-- The dots/circles -->
    <div style="text-align:center">
        ${itemSetSlideDotHtmls}
    </div>
    `;

    let currentIndex = 0;

    function showSlides(num) {
        let slides = document.getElementsByClassName("item-slide");
        let dots = document.getElementsByClassName("item-slide-dot");

        if (num > itemSetSlides.length - 1) {currentIndex = 0}
        if (num < 0) {currentIndex = itemSetSlides.length - 1}

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

    // Thumbnail image controls
    function openCurrentSlide(n) {
        showSlides(currentIndex = n);
    }

    document.getElementById(where_id).innerHTML = slideShowHtml;

    showSlides(currentIndex);


    // bind events
    document.getElementById(`item_prev_button`).onclick = function () {plusSlides(-1)};
    document.getElementById(`item_next_button`).onclick = function () {plusSlides(1)};

    let dots = document.getElementsByClassName("item-slide-dot");
    for (let i = 0; i < dots.length; i++) {
        dots[i].onclick = function () {openCurrentSlide(i)};
    }

    highlightItems.forEach(bindHandlersSlideItemBanner);
}




