////////////////////////////// ANIMATION SUR LE FORMULAIRE /////////////////////////////////////////////
// slideDown
$( document ).ready(function () {
  if ( $( "#frm" ).is( ":hidden" ) ) {
    $( "#frm" ).slideDown(2000);
  } else {
    $( "#frm" ).slideDown(2000);
  }
});
///////////////////////////// POUR CONVERTIR LES BYTES EN OCTETS ETC. //////////////////////////////////
function FileConvertSize(aSize){
    aSize = Math.abs(parseInt(aSize, 10));
    var def = [[1, 'octets'], [1024, 'ko'], [1024*1024, 'Mo'], [1024*1024*1024, 'Go'], [1024*1024*1024*1024, 'To']];
    for(var i=0; i<def.length; i++){
        if(aSize<def[i][0]) return (aSize/def[i-1][0]).toFixed(2)+' '+def[i-1][1];
    }
}

/////////////////////////////// POUR AFFICHER LA MINIATURE//////////////////////////////////////////////
            $(function () {
                $('#frm').on('submit', function (e) {
                    //e.preventDefault();// On empêche le navigateur de soumettre le formulaire
                    var $form = $(this);
                    var formdata = (window.FormData) ? new FormData($form[0]) : null;
                    var data = (formdata !== null) ? formdata : $form.serialize();
                });

                // A change sélection de fichier
                $('#frm').find('input[name="fichier"]').on('change', function (e) {
                    var files = $(this)[0].files;

                    if (files.length > 0) {
                        // On part du principe qu'il n'y qu'un seul fichier
                        // étant donné que l'on a pas renseigné l'attribut "multiple"
                        var file = files[0],
                            $image_preview = $('#image_preview');

                        // Ici on injecte les informations recoltées sur le fichier pour l'utilisateur
                        $image_preview.find('.thumbnail').removeClass('hidden');
                        $image_preview.find('img').attr('src', window.URL.createObjectURL(file));
                        $image_preview.find('.nom_photo').html("La photo se nomme <b>" + file.name + "</b>");
                        $image_preview.find('.poids').html(" Son poids est de <b>" + FileConvertSize(file.size) + '</b>');
                    }
                });

                    // Bouton "Annuler"
                    /*$('#image_preview').find('button[type="button"]').on('click', function (e) {*/
                    $('#image_preview').find('i[id="close"]').on('click', function (e) {
                    e.preventDefault();

                    // On cache "image_preview"
                    document.getElementById('image_preview').style.display = "none";
                    document.getElementById('image_preview').style.zIndex = "1";
                        
                    $('#frm').find('input[name="fichier"]').val('');
                    $('#image_preview').find('.thumbnail').addClass('hidden');
                });
            });
            /*Pour afficher la miniature seulement si il y a une photo dans l'input*/

                $(document).ready(function(){
                    $("input[type='file']").change(function(){
                    document.getElementById('image_preview').style.display = "block";
                    document.getElementById('image_preview').style.zIndex = "10";   
                }  
                );                   
            });

////////////////////// LA BARRE DE PROGRESSION POUR LE TRANSFERT DE L'IMAGE ////////////////////////////
