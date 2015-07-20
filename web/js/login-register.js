/*
 *
 * login-register modal
 * Autor: Creative Tim
 * Web-autor: creative.tim
 * Web script: http://creative-tim.com
 * 
 */
function showRegisterForm(){
    $('.loginBox').fadeOut('fast',function(){
        $('.registerBox').fadeIn('fast');
        $('.login-footer').fadeOut('fast',function(){
            $('.register-footer').fadeIn('fast');
        });
        $('.modal-title').html('Register');
    }); 
    $('.error').removeClass('alert alert-danger').html('');
       
}
function showLoginForm(){
    $('#loginModal .registerBox').fadeOut('fast',function(){
        $('.loginBox').fadeIn('fast');
        $('.register-footer').fadeOut('fast',function(){
            $('.login-footer').fadeIn('fast');    
        });
        
        $('.modal-title').html('Login');
    });       
     $('.error').removeClass('alert alert-danger').html(''); 
}

function openLoginModal(){
    showLoginForm();
    setTimeout(function(){
        $('#loginModal').modal('show');    
    }, 230);
    
}
function openRegisterModal(){
    showRegisterForm();
    setTimeout(function(){
        $('#loginModal').modal('show');    
    }, 230);
    
}

function loginAjax(){

        
        $.ajax({
			type        : 'POST', 
			url         : 'login.php', 
			data        : $('.loginBox form').serialize(), 
			encode      : true
		}).done(function( data ) {
            if(data == 1){
                window.location.reload();            
            } else {
                 shakeModal(["Invalid email/password combination"]); 
            }
        });
}

function registerAjax(){

        
        $.ajax({
			type        : 'POST', 
			url         : 'sign-up.php', 
			data        : $('.registerBox form').serialize(), 
			dataType    : 'json', 
			encode      : true
		}).done(function( data ) {
            if(data['success']){
                window.location.href = 'index.php?signedup';        
            } else {
                 shakeModal(data.error); 
            }
        });
}

function shakeModal(errors){
    $('#loginModal .modal-dialog').addClass('shake');
             $('.error').addClass('alert alert-danger').html('<ul><li>'+errors.join('</li><li>')+'</li></ul>');
             $('input[type="password"]').val('');
             setTimeout( function(){ 
                $('#loginModal .modal-dialog').removeClass('shake'); 
    }, 1000 ); 
}

   