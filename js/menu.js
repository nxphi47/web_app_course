function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}


function openTab(event, tabName) {
    let i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    event.currentTarget.className += " active";
}


// --------- TESTING ----------------
function generateFakeItemData(size, type='Pizza') {
    let dataList = [];
    for (let i =0; i < size; i++) {
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

        dataList.push(item);
    }

    return dataList;
}

componentItemList(`item-list-wrapper-all`, generateFakeItemData(10, 'Pizza & else'));
componentItemList(`item-list-wrapper-pizza`, generateFakeItemData(10, 'Pizza'));
componentItemList(`item-list-wrapper-pasta`, generateFakeItemData(10, 'Pasta'));
componentItemList(`item-list-wrapper-beverage`, generateFakeItemData(10, 'Drink'));

document.getElementById("default-tab").click();
// --- EXECUTION ---------