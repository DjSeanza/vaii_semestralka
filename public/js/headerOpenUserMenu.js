function openUserMenu(userId) {
    let button = document.querySelector("div#header-right");
    let menu = document.querySelector("div#header-user-menu");

    if (menu == null) {
        button.innerHTML += '' +
            '<div id="header-user-menu">' +
            '<ul class="header-user-ul-menu">' +
            '   <li onclick="location.href=\'?c=studio&a=listContent\'">Moje videá</li>' +
            '   <li onclick="location.href=\'?c=auth&a=deleteUser&uid=' + userId + '\'">Vymazať konto</li>' +
            '   <li onclick="location.href=\'?c=auth&a=logout\'">Odhlásiť</li>' +
            '</ul>'
            '</div>';
    }
}

document.addEventListener("click", function() {
    let menu = document.querySelector("div#header-user-menu");

    if (menu != null) {
        menu.remove();
    }
}, true);