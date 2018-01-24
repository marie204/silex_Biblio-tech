// Pour le menu burger
$(document).ready(function(){
  $('.button-collapse').sideNav({
      menuWidth: 270, // Default is 240
      edge: 'left', // Choose the horizontal origin
      closeOnClick: false // Closes side-nav on <a> clicks, useful for Angular/Meteor
    }
  );
});

// Le sous-menu du menu hamburger
/*    function sousMenu() {
        sous_menu = document.getElementById('sousMenu-mobile');
        btn_sous_menu = document.getElementById('btn-sous-menu');

        if (sous_menu.style.display == 'none' ||  sous_menu.style.display == '') {
            sous_menu.style.display = 'block';
            btn_sous_menu.innerHTML = "clear";
            }
        else {
            sous_menu.style.display = 'none';
            btn_sous_menu.innerHTML = "add";
            }
        }
        btn_sous_menu.addEventListener("click", sousMenu);*/

/*SELECT*/
$(document).ready(function() {
  $('select').material_select();
});
