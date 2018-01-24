/*Caroussel page accueil*/
$('.carousel').carousel({
interval: 2000
})
/*Page contact*/
$(function(){
	$("#envoyer").click(function(){
	valid=true;
	/*NOM*/
	if ($("#nom").val() =="" ) {
	$("#nom").css("border","2px solid red");
	$("#erreurNom").html("Vous devez saisir votre nom");
	valid=false;
	}
	else {
	$("#erreurNom").html("");
	$("#nom").css("border","2px solid lightgreen")
	}
	/*E-MAIL*/
	if ($("#email").val() =="" ) {
	$("#email").css("border","2px solid red");
	$("#erreurMail").html("Vous devez saisir votre mail");
	valid=false;
	}
	else if
	(!$("#email").val().match(/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})/i)) {
	$("#email").css("border","2px solid red");
	$("#erreurMail").html("");
	$("#erreurMailNonValide").html("Votre mail n'est pas valide");
	valid=false;
	}
	else {
	$("#erreurMail").html("");
	$("#erreurMailNonValide").html("");
	$("#email").css("border","2px solid lightgreen");
	}
	/*TELEPHONE*/
	if ($("#tel").val() =="" ) {
	$("#tel").css("border","2px solid red");
	$("#erreurTel").html("Vous devez saisir votre téléphone");
	valid=false;
	}
	else if
	(!$("#tel").val().match(/^[0-9]{10}/i)) {
	$("#tel").css("border","2px solid red");
	$("#erreurTel").html("");
	$("#erreurTelNonValide").html("Le téléphone n'est pas valide");
	valid=false;
	}
	else {
	$("#erreurTel").html("");
	$("#erreurTelNonValide").html("");
	$("#tel").css("border","2px solid lightgreen");
	}
	/*MESSAGE*/
	if ($("#message").val() =="" ) {
	$("#message").css("border","2px solid red");
	$("#erreurMessage").html("Vous devez saisir votre message");
	valid=false;
	}
	else {
	$("#erreurMessage").html("");
	$("#message").css("border","2px solid lightgreen");
	}
return valid;
});
});