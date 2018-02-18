/*Ouverture menu swipe*/
$(function(){
    $("#openbtn").click(function(){
    $("#mySidenav").css("width","80%");
});
});
$(function(){
    $("#closebtn").click(function(){
    $("#mySidenav").css("width","0");
});
});

/*Ouverture sous menu*/
$(function(){
    $("#open1").click(function ()
        {
        if($('#mobiles-menu-1').css('display')=='none') {
            $("#open1").html("clear");
        }
        else {
            $("#open1").html("add");
        }   
        $( "#mobiles-menu-1" ).slideToggle(250);
    });
});