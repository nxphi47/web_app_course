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

let all_menu = rootData.menu;
let pizza_menu = all_menu.filter((x) => x.type.toLowerCase() == 'pizza');
let pasta_menu = all_menu.filter((x) => x.type.toLowerCase() == 'pasta');
let drink_menu = all_menu.filter((x) => x.type.toLowerCase() == 'beverage');
let promotion_menu = all_menu.filter((x) => x.type.toLowerCase() == 'promotion');


componentItemList(`item-list-wrapper-all`, all_menu);
componentItemList(`item-list-wrapper-pizza`, pizza_menu);
componentItemList(`item-list-wrapper-pasta`, pasta_menu);
componentItemList(`item-list-wrapper-beverage`, drink_menu, false);
componentItemList(`item-list-wrapper-promotion`, promotion_menu, false);


function onSearch() {
    const string = document.getElementById("search_input").value;
    let items;
    if (string === "") {
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