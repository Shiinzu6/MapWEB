$(document).ready(init);


function init(){

    // SE LOGIN

    $('.submitLoginForm').submit(function(){

        var email = $('#email').val();
        var prenom = $('#prenom').val();
        var nom = $('#nom').val();
        var num = $('#num').val();
        var uname = $('#uname').val();
        var psw = $('#psw').val();

        $.post('enregistrement.php',{email:email,prenom:prenom,nom:nom,num:num,
            uname:uname,psw:psw},function(donnees){
            $('.infoConnexion').html(donnees).slideDown();
            $('.infoConnexion').css('color','white');
        });
    return false;
    });

}