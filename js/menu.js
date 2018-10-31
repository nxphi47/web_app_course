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

let all_menu = rootData.menu;
let pizza_menu = all_menu.filter((x) => x.type.toLowerCase() == 'pizza');
let pasta_menu = all_menu.filter((x) => x.type.toLowerCase() == 'pasta');
let drink_menu = all_menu.filter((x) => x.type.toLowerCase() == 'beverage');


componentItemList(`item-list-wrapper-all`, all_menu);
componentItemList(`item-list-wrapper-pizza`, pizza_menu);
componentItemList(`item-list-wrapper-pasta`, pasta_menu);
componentItemList(`item-list-wrapper-beverage`, drink_menu, false);


function onSearch() {
    const string = document.getElementById("search_input").value;
    // console.log("perform search");
    let items;
    if (string === "") {
        // componentItemList(`item-list-wrapper-all`, all_menu);
        items = all_menu;
    }
    else {
        items = all_menu.filter((v) => {
            return v.title.toLowerCase().match(string) != null;
        });
    }

    componentItemList(`item-list-wrapper-all`, items);
    document.getElementById("default-tab").click();
}


document.getElementById("default-tab").click();
// --- EXECUTION ---------


console.log(rootData);