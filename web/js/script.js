/*MENU SWIPE*/
/*Ouverture*/
$('#openbtn').click(function(){
	$('#menu-xs').css('width', '80%')
});
/*Fermeture*/
$('#closebtn').click(function(){
	$('#menu-xs').css('width', '0%')
});

/*Sous-menu*/
$("#btn-sous-menu").click(function(){
    var sous_menu = $('#ul-sous-menu-mobile');
    var btn_sous_menu = $('#btn-sous-menu');
    var li = $('#li-sous-menu-mobile')
    li.slideToggle(100);
    sous_menu.css('display','block');
    if (sous_menu.css('display','none') || (sous_menu.css('display',''))) {
        btn_sous_menu.html("arrow_drop_up");
        sous_menu.css('display','block');
    }
    else {
        btn_sous_menu.html("arrow_drop_down");
        sous_menu.css('display','none');
    }
});

/*HAUT DE PAGE*/
/*Flêche pour le retour en haut*/
$(document).ready(function(){
// Condition d'affichage du bouton
    $(window).scroll(function(){
        if ($(this).scrollTop() > 150){
            $('.haut').fadeIn();
        }
        else{
            $('.haut').fadeOut();
        }
});
    // Evenement au clic
    $('.haut').click(function(){
        $('html, body').animate({scrollTop : 1},500);
        return false;
    });
});