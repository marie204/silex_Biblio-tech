function openNav() {
    document.getElementById("mySidenav").style.width = "80%";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

/*SOUS MENU*/
    function sous_menu1() {
        sous_menu = document.getElementById('mobiles-menu-1');
        btn_sous_menu = document.getElementById('open1');

        if (sous_menu.style.display == 'none' ||  sous_menu.style.display == '') {
            sous_menu.style.display = 'block';
            btn_sous_menu.innerHTML = "clear";
            }
        else {
            sous_menu.style.display = 'none';
            btn_sous_menu.innerHTML = "add";
            }
        }
        btn_sous_menu.addEventListener("click", sous_menu1);