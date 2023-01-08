$(document).ready(init);


function init(){

    // SE LOGIN

    $('#test').click(function(){
        alert("OK");
        console.log("OK");
    });

    $('.submitLoginForm').submit(function(){

        var email = $('#email').val();
        var mdp = $('#mdp').val();

        $.post('login.php',{email:email,password:mdp},function(donnees){
            $('.infoConnexion').html(donnees).slideDown();
            $('.infoConnexion').css('color','white');
        });
    return false;
    });

}