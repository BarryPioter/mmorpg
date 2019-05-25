function account(x) {
    switch (x) {
        case 1:
            document.getElementById("acc1").style.display = 'block';
            document.getElementById("acc2").style.display = 'none';
            document.getElementById("acc3").style.display = 'none';
            document.getElementById("acc4").style.display = 'none';
            break;
        case 2:
            document.getElementById("acc1").style.display = 'none';
            document.getElementById("acc2").style.display = 'block';
            document.getElementById("acc3").style.display = 'none';
            document.getElementById("acc4").style.display = 'none';
            break;
        case 3:
            document.getElementById("acc1").style.display = 'none';
            document.getElementById("acc2").style.display = 'none';
            document.getElementById("acc3").style.display = 'block';
            document.getElementById("acc4").style.display = 'none';
            break;
        case 4:
            document.getElementById("acc1").style.display = 'none';
            document.getElementById("acc2").style.display = 'none';
            document.getElementById("acc3").style.display = 'none';
            document.getElementById("acc4").style.display = 'block';
            break;
    }
}

function characters(x) {
    switch (x) {
        case 1:
            document.getElementById("chars1").style.display = 'block';
            document.getElementById("chars2").style.display = 'none';
            break;
        case 2:
            document.getElementById("chars1").style.display = 'none';
            document.getElementById("chars2").style.display = 'block';
            break;
    }
}

function showEq(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("eq").innerHTML = this.responseText;
        }
    }
    var l = document.getElementById("charid");
    var c = l.options[l.selectedIndex].value;
    xmlhttp.open("GET", "../game/equipment.php?c=" + c + "&t=" + x, true);
    xmlhttp.send();
}
function enchant(x, i) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("ench").innerHTML = this.responseText;
            showEq();
            showchar();

        }
    }
    var l = document.getElementById("charid");
    var c = l.options[l.selectedIndex].value;
    xmlhttp.open("GET", "../game/ench.php?eq=" + x + "&c=" + c + "&i=" + i, true);
    xmlhttp.send();
}
function submitGame(x)
{
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        document.getElementById("gameOut").innerHTML = xhr.responseText;
        showchar(0, "");
    } // success case
    xhr.onerror = function () {
        alert(xhr.responseText);
    } // failure case
    var formData = new FormData(document.getElementById('char'));
    formData.append("mode", x);
    xhr.open("post", "game/game.php", true);
    xhr.send(formData);
    return false;
}
function showchar(x, s) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("charinfo").innerHTML = this.responseText;
        }
    }
    var l = document.getElementById("charid");
    var c = l.options[l.selectedIndex].value;
    xmlhttp.open("GET", s + "game/charinfo.php?id=" + c + "&t=" + x, true);
    xmlhttp.send();
}
function buy(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("shopinfo").innerHTML = this.responseText;
            showchar(0, '../');

        }
    }
    var l = document.getElementById("charid");
    var c = l.options[l.selectedIndex].value;
    xmlhttp.open("GET", "../game/buy.php?i=" + x + "&c=" + c, true);
    xmlhttp.send();
}
function showShop(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("shop").innerHTML = this.responseText;
        }
    }

    xmlhttp.open("GET", "../game/shoplist.php?t=" + x, true);
    xmlhttp.send();
}



function addStat(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cerr").innerHTML = this.responseText;
            showEq();
            showchar(2, '../');

        }
    }
    var l = document.getElementById("charid");
    var c = l.options[l.selectedIndex].value;
    xmlhttp.open("GET", "../game/addPoint.php?stat=" + x + "&charid=" + c, true);
    xmlhttp.send();
}

function showReports(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("reports").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "../core/reportlist.php?t=" + x, true);
    xmlhttp.send();
}

function checkReport(x, id) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("reportinfo").innerHTML = this.responseText;
            if (x == 3)
                showReports(1);
            else if (x == 1 || x == 2)
                showReports(3);
        }
    }

    xmlhttp.open("GET", "../core/checkreport.php?t=" + x + "&id=" + id, true);
    xmlhttp.send();
}

function showBans(x, y) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("bans").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "../core/banlist.php?t=" + x + "&id=" + y, true);
    xmlhttp.send();
}

function ban() {
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        document.getElementById("baninfo").innerHTML = xhr.responseText;
    } // success case
    xhr.onerror = function () {
        alert(xhr.responseText);
    } // failure case
    var formData = new FormData(document.getElementById('newban'));
    xhr.open("post", "../core/ban.php", true);
    xhr.send(formData);
    return false;
}

function unban(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("baninfo").innerHTML = this.responseText;
            showBans(3);
        }
    }
    xmlhttp.open("GET", "../core/unban.php?t=" + x, true);
    xmlhttp.send();
}

function showItems(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("items").innerHTML = this.responseText;
            document.getElementById("iteminfo").innerHTML = "";
        }
    }
    xmlhttp.open("GET", "../game/itemslist.php?t=" + x, true);
    xmlhttp.send();
}

function promote(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

        }
    }
    xmlhttp.open("GET", "../core/promote.php?id=" + x, true);
    xmlhttp.send();
}

function changeAdminPriv(id, priv) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("adminfo").innerHTML = this.responseText;
            location.reload();
        }
    }
    xmlhttp.open("GET", "../core/priv.php?id=" + id + "&priv=" + priv, true);
    xmlhttp.send();
}

function additem(x) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        document.getElementById("iteminfo").innerHTML = xhr.responseText;
    } // success case
    xhr.onerror = function () {
        alert(xhr.responseText);
    } // failure case
    var formData = new FormData(document.getElementById('newitem'));
    formData.append("type", x);
    xhr.open("post", "../game/additem.php", true);
    xhr.send(formData);
    return false;
}

function activateItem(id, type) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("iteminfo").innerHTML = this.responseText;
            showItems(type);
        }
    }
    xmlhttp.open("GET", "../game/activateitem.php?id=" + id + "&type=" + type, true);
    xmlhttp.send();
}

function raports(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("rapinfo").innerHTML = this.responseText;
            raportsshow(x, 1);
        }
    }
    xmlhttp.open("GET", "../core/raport.php?t=" + x, true);
    xmlhttp.send();
}

function raportsshow(x) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("raport").innerHTML = this.responseText;
        }
    }
    var y =document.querySelector("input[name=mode]:checked").value;
    var l = document.getElementById("duration");
    var c = l.options[l.selectedIndex].value;
    xmlhttp.open("GET", "../core/raportlist.php?t=" + x + "&m=" + y + "&d=" + c, true);
    xmlhttp.send();
}
