function placeholder(e) {
    console.log(e);
}

function itemBanner(id, title, price, note, desc, thumbnail, url) {
    let template = `
    <div class="responsive" id="item_banner_${id}">
        <div class="item-banner">
            <a href="#" id="item_img_${id}">
                <img src="${thumbnail}" alt="Not found" width="600" height="400">
            </a>
            <div class="desc">
                <span class="desc">
                    <span class="title">${title}</span>
                    <span class="price">$${price}</span>
                    <span class="note">${note}</span>
                </span>
                <button class="button desc" id="add_cart_${id}">Add to Cart</button>
            </div>
        </div>
    </div>
    <!--Pop up window here-->
    <div id="item_modal_${id}" class="modal" style="display: none;">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" id="item_modal_close_${id}">&times;</span>
            <div class="modal-content-inside">
                <div class="image">
                    <img src="${url}" alt="Image Not found" width="600" height="400">
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
                        <button class="button" id="add_cart_modal_${id}">Add to Cart</button>
                    </div>
                </div>
                
            </div>
        </div>
    
    </div>
    `;
    return template
}


function componentItemList(where_id, data_list) {
    let itemHtmls = ``;
    console.log(data_list);

    data_list.forEach(function (item, i) {
        itemHtmls += itemBanner(item.id, item.title, item.price, item.note, item.desc, item.thumbnail, item.img_url);
    });


    let componentListTemplate = `
    <div class="item-list" id="main-item-list">
        ${itemHtmls}
    </div>
    <div class="clearfix"></div>
    `;

    document.getElementById(where_id).innerHTML = componentListTemplate;

    // functions
    data_list.forEach(function (item, i) {

        let onClickImg = function (e) {
            const modal = document.getElementById(`item_modal_${item.id}`);
            modal.style.display = "block"
        };

        let onModalClose = function () {
            const modal = document.getElementById(`item_modal_${item.id}`);
            modal.style.display = "none";
        };

        let onAdd = function (e) {
            console.log(`click add on item ${i}`);
            console.log(item);
        };

        document.getElementById(`item_img_${item.id}`).onclick = onClickImg;
        document.getElementById(`add_cart_${item.id}`).onclick = onAdd;
        document.getElementById(`add_cart_modal_${item.id}`).onclick = onAdd;
        document.getElementById(`item_modal_close_${item.id}`).onclick = onModalClose;
    });

    return componentListTemplate;
}
